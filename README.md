# What is this?


A home-brew implementation of BMW's Online portal for ID2 CIC infotainment units.

If your telematics subscription is still active you can still access the original BMW servers. The public proxy that was accessible through Bluetooth tethering was shut down around 2018.

Modifications and pull requests highly encouraged!


## Scope

Only the Online / Live section is implemented. Internet requires binauth (I haven't figured out how to do this yet) and Squid bumping to account for the fact that almost no websites use SSL or TLS1.0

## Portal features

News - powered by 68knews  
Weather - parsed from weather.com  
Search - powered by frogfind  
A somewhat crude lap timer  
A world clock  
Whatever else you wish to add :)


# Server VM

https://mega.nz/file/vWohwaYD#P4wy5eISmEGCdT10b6FT_22ruv8qL8WNToAgDkd2LWA  
Use this VM to skip configuring the webserver and proxy.  
This is not kept up-to-date. You may have to update the portal files manually.  
The static IP may need to be reconfigured depending on your network setup.  
`sudo vi /etc/systemd/network/25-wired.network`  
Port 8080 must be opened and forwarded on your router.  

Edit /var/www/html/provision.xml and replace \*\*your IP\*\* with your static IP.



# Manual Installation


## Overview of the process

1. Set up a static IP web server. Either create it with the instructions provided or download the pre-made VM.

2. Set up the Squid proxy and host the portal pages from the server.

3. The Combox contains a set of XMLs that it falls back on if provisioning updates fail. This step can be skipped however, doing so could lead to the Combox defaulting to the BMW proxy IPs.

4. Code CIC and Combox.

5. Upload provisioning via Tool32 or 'Update Services' if Combox XMLs are modified.



## Server

You have a choice here. Self-hosted or cloud. It's typically quite difficult to obtain a static IP from a residential ISP. You don't want this IP to change especially if you modify the Combox XML(s).

For self-hosted I'd recommend a Debian VM.
For cloud, a small Lightsail instance is $3.50/month.

You will need an http web-server (Apache, Lighttpd, NGINX, etc.) and PHP.


The instructions below apply for a Debian instance and PHP7.3.


Install packages:  
`sudo su -c 'apt update && apt upgrade -y && apt install lighttpd php-fpm php-xml php-curl php-gd php-mbstring -y'`


Configure server:  
`ln -s /var/www/html/ web-root && sudo su -c 'chown admin:admin /var/www/ -R && echo "cgi.fix_pathinfo=1" >> /etc/php/7.3/fpm/php.ini && ln -s /etc/lighttpd/conf-available/10-fastcgi.conf /etc/lighttpd/conf-enabled/ && ln -s /etc/lighttpd/conf-available/15-fastcgi-php.conf /etc/lighttpd/conf-enabled/' `


Modify configuration:  
`sudo vi /etc/lighttpd/conf-available/15-fastcgi-php.conf`

```
fastcgi.server += ( ".php" => 
	((
		"socket" => "/run/php/php7.3-fpm.sock",
		"broken-scriptfilename" => "enable"
	))
)
```

Re-start the server:  
`sudo service lighttpd force-reload`


Copy the portal files to the web root (/var/www/html/) and change permissions for settings files, cache folder for frogfind,news:  

`sudo su -c 'sudo chown www-data:www-data /var/www/html/settings/vehicle -R; sudo chown www-data:www-data /var/www/html/search/php/library/cache -R; sudo chown www-data:www-data /var/www/html/news/php/library/cache -R; sudo chown www-data:www-data /var/www/html/weather/cache'`



## Squid


All requests from the CIC are proxied before they reach a server. We will set up a http proxy with basic auth. An added benefit of the proxy is that you don't need to keep port 80 open to the world.


`sudo apt install squid apache2-utils -y`  
`sudo su -c 'touch /etc/squid/passwords && chmod 777 /etc/squid/passwords && htpasswd -c /etc/squid/passwords b2v_standard'`  
`sudo mv /etc/squid/squid.conf /etc/squid/squid.conf.original && sudo vi /etc/squid/squid.conf`  


```
auth_param basic program /usr/lib/squid/basic_ncsa_auth /etc/squid/passwords
auth_param basic realm Squid proxy-caching web server
auth_param basic credentialsttl 24 hours
acl authenticated proxy_auth REQUIRED
http_access allow authenticated
http_access deny all
dns_v4_first on
forwarded_for delete
via off
http_port 8080
cache deny all
```


If ufw is installed:  
`sudo ufw allow 8080/tcp && sudo service squid restart`



## Combox


The Combox uses essentially the same hardware as the CIC sans the Fujitsu Carmine gpu and half the RAM. If you read the HARMAN manual you will note that pins 8 (TX), 9 (RX) and 16 (GND) are UART to the SH4 chip.

Hook up a simple UART (57600) adapter to those pins and you will see debug output that is printed by a custom binary (TestMenu). However, in order to do anything fun like say, execute commands we will need to login to this binary with root access. 




1. Press l - login to level 1 (default access) with password "COMBOX__01HB".​

2. Press 2 - log menu -> write to usb (usb drive plugged in to armrest).​
   This creates a folder "Log\_\*day\*\_\*month\*\_\*year\*\_\_\*hour\*\_\*minutes\*\_\*seconds\*​
   Get Protect.DAT from subdirectory "HBHK" and rename it to "t.DAT".

3. FTP into CIC and upload comboxconsole, rootpersists.DAT and t.DAT to /mnt/hbuser.

4. SSH into CIC and run:

`cd /mnt/hbuser && chmod +x comboxconsole && ./comboxconsole`

5. l - login, 6 - Show Passwords


Modify the XML provided to include your proxy IP. Place your modified XMLs to the root of a usb drive in a folder named "xml", log in as root on the Combox and exit to shell (0). Run:  

`mount -o remount rw /HBProvisioning && cp /mnt/umass00100t12/xml/* /HBProvisioning/xml/ && mount -o remount ro /HBProvisioning && rm -r /HBProvisioningDyn/* && slay BMW_MAIN`



## Coding


### Combox

```
DPAS_INDEX
	dpas_3
CONFIG_INDEX
	config_index_3
SIM_ENABLED_MB
	csim
```


### CIC




## Provisioning

The provisioning file contains markup that describes what Online services are available, where they can be reached and how they should be configured.
Replace \*your IP\* with the IP address of the proxy.

To load manually with Tool32:

1. Copy provisioning.xml to root of the C: drive.

2. Start Tool32 and load CMEDIAR.PRG.

3. Select job schreiben_ota, set argument C:\provision.xml and execute.




## Notes/gotchas

* The proxy defined in the provisioning XML must be an IPv4 instead of a domain name. Domain names cannot be resolved at this stage.
* The server address can be defined as both a domain name or IPv4. Setting to an IP should save on a DNS query.
* Setting addresses such as BON and provisioning to 127.0.0.1 speeds up access since Squid won't have to make a DNS query.
* Static assets such as PNGs are cached but only for the current session.
* PSIM (Prefit SIM), CSIM (Customer SIM)
* The Ghidra module for SH4 is quite good.


Browser engine specs [NetFront 3.4]:

- HTML4.01, XHTML1.1, cHTML, XHTML Basic 1.0, WML1.3
- CSS 1 & 2
- ECMAScript 3rd Edition (JavaScript 1.5)
- DOM1, 2 and Dynamic HTML
- GIF, animated GIF, BMP, PNG, JPEG and MNG
- HTTP1.1
- SSL2.0/3.0,TLS1.0
- Cookies
