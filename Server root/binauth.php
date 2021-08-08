<?php

	$VIN = $_SERVER['HTTP_BMW_VIN'];

	setcookie("VEHICLEAUTH", 3, time()+21600);		//expire in 6hrs
	setcookie("VINRN", $VIN, time()+21600);
	setcookie("USERAUTH", 3, time()+21600);
	setcookie("JSESSIONID", 1, time()+21600);
	//header('Content-Type: application/xml');
	//readfile("/home/bitnami/binauth.xml");


	//header("Location: http://t.com/");
	//echo "BINAUTH";
?>