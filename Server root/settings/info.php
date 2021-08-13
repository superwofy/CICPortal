<?php
$lat = isset($_GET['lat']) ? $_GET['lat'] : "0";
$long = isset($_GET['long']) ? $_GET['long'] : "0";
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
$VIN = ctype_alnum($VIN) ? $VIN : "E000000";
header("Content-type: application/xhtml+xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal > Information</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
</head>
<body>
<?php 
echo "<h1>VIN: {$VIN}</h1>";
echo "<h1>GPS-Location: {$lat}, {$long}</h1>";
echo "<h1>UA-HTTP: {$_SERVER['HTTP_USER_AGENT']}</h1>";
echo "<h1>Server: {$_SERVER['SERVER_SOFTWARE']}</h1>";
echo "<h1>Portal updated: ".date("F d Y H:i:s", filemtime("../bonstartpage.php"))."</h1>";
?>
<h1 id="screen-size"></h1>
<script type="text/javascript">document.getElementById("screen-size").innerHTML="Window size: "+Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)+"x"+Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)+"px";</script>
</body>
</html> 

