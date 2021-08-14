<?php

$lat = isset($_GET['lat']) ? $_GET['lat'] : "0";
$long = isset($_GET['long']) ? $_GET['long'] : "0";
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($VIN) ? $VIN : "E000000") : "E000000";
$filename = getcwd().'/settings/vehicle/'.$VIN.'.json';
$settings = "";

if (file_exists($filename)) $settings = file_get_contents($filename);
else $settings = file_get_contents(getcwd().'/settings/vehicle/'.'E000000.json');

$settings = json_decode($settings);

$welcomemsg = $settings->welcomemsg;
$message_color = $settings->message_color;
$date_color = $settings->date_color;
$logo_setting = $settings->logo_setting;
$timezone = $settings->timezone;

$now = new DateTime();
if (isset($_GET['development'])) {setcookie("development", 1);}

header("Content-type: application/xhtml+xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal Home</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
<link href="/assets/css/main.css" type="text/css" rel="stylesheet"/>
</head>
<body style="margin-top:20px">
<div>
<div class="column">
<a href="<?php echo "/weather/main.php?lat={$lat}&amp;long={$long}"; ?>"><img src="/assets/img/clouds-32.png" height="32px" alt=""/>Weather</a>
<a href="/news/index.php"><img src="/assets/img/newspaper-32.png" height="32px" alt=""/>News</a>
<a href="/search/index.php"><img src="/assets/img/search-3-32.png" height="32px" alt=""/>Search</a>
<a href="/extras/main.php"><img src="/assets/img/window-apps-32.png" height="32px" alt=""/>Extras</a>
<a href="<?php echo "/settings/main.php?lat={$lat}&amp;long={$long}"; ?>"><img src="/assets/img/settings-5-32.png" height="32px" alt=""/>Settings</a>
</div>
<div class="column column2">
<p style="color:<?php echo $date_color . '">' . $now->format('d-m-Y'); ?></p>
<img style="margin:10px 0 0 0" src="/assets/img/widget-images/<?php echo $logo_setting; ?>.png" alt="Logo"/>
<?php if (!empty($welcomemsg)) echo "<h1 style=\"color:{$message_color}\">{$welcomemsg}</h1>"; ?>
</div>
</div> 
</body>
</html> 