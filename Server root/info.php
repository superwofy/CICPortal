<?php
$lat = isset($_GET['lat']) ? (is_numeric($_GET['lat']) ? round(intval($_GET['lat']) / 11930464.71, 5) : "Incorrect lat") : "No lat";            //Decode compressed GPS co-ordinates.
$long = isset($_GET['long']) ? (is_numeric($_GET['long']) ? round(intval($_GET['long']) / 11930464.71, 5) : "Incorrect long") : "No long";
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "Not provided") : "Not provided";

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal >> Info</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
</head>
<body>
<?php 
echo "<h1>VIN: {$VIN}</h1>";
echo "<h1>GPS-Location: {$lat}, {$long}</h1>";
echo "<h1>UA-HTTP: {$_SERVER['HTTP_USER_AGENT']}</h1>";
echo "<h1>Protocol: {$_SERVER['SERVER_PROTOCOL']} {$_SERVER['HTTP_ACCEPT_ENCODING']}</h1>";
echo "<h1>Portal updated: ".date("F d Y H:i:s", filemtime("bonstartpage.php"))."</h1>";
?>
<h1 id="screen-size"></h1>
<script type="text/javascript">document.getElementById("screen-size").innerHTML="Window size: "+Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)+"x"+Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)+"px";</script>
</body>
</html> 

