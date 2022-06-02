<?php
$lat = isset($_GET['lat']) ? (is_numeric($_GET['lat']) ? round(intval($_GET['lat']) / 11930464.71, 2) : "Incorrect lat") : "No lat";            //Decode compressed GPS co-ordinates.
$long = isset($_GET['long']) ? (is_numeric($_GET['long']) ? round(intval($_GET['long']) / 11930464.71, 2) : "Incorrect long") : "No long";
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "Not provided") : "Not provided";
header("Content-type: application/xhtml+xml");
ob_start("ob_gzhandler");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal >> Info</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
</head>
<body>
<?php 
echo "<h1>VIN: {$VIN}</h1>";
echo "<h1>GPS-Location: {$lat}, {$long}</h1>";
echo "<h1>UA-HTTP: {$_SERVER['HTTP_USER_AGENT']}</h1>";
echo "<h1>Protocol: {$_SERVER['SERVER_PROTOCOL']}</h1>";
//echo "<h1>Server: {$_SERVER['SERVER_SOFTWARE']}</h1>";
echo "<h1>Portal updated: ".date("F d Y H:i:s", filemtime("../bonstartpage.php"))."</h1>";
?>
<h1 id="screen-size"></h1>
<script type="text/javascript">document.getElementById("screen-size").innerHTML="Window size: "+Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)+"x"+Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)+"px";</script>
</body>
</html> 

