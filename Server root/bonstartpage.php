<?php

$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000") : "E000000";
$filename = getcwd().'/settings/vehicle/'.$VIN.'.json';

if (!preg_match('/^' . str_replace('/', "\/", getcwd()) . "\/settings\/vehicle\/[A-Z|0-9]{7}.json$/", $filename))      //attempt to prevent directory traversal with $VIN
    exit();

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

$weather_data = file_get_contents("http://127.0.0.1/weather/get-weather.php?lat={$_GET['lat']}&long={$_GET['long']}&VIN={$VIN}");

header("Content-type: application/xhtml+xml");
ob_start("ob_gzhandler");
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
<body style="margin-top:10px">
<div>
<div class="column" style="margin-top:10px">
<a href="<?php echo "/weather/main.php?lat={$_GET['lat']}&amp;long={$_GET['long']}"; ?>"><img src="/assets/img/clouds-32.png" height="32px" alt=""/>Weather</a>
<a href="/news/index.php"><img src="/assets/img/newspaper-32.png" height="32px" alt=""/>News</a>
<a href="/search/index.php"><img src="/assets/img/search-3-32.png" height="32px" alt=""/>Search</a>
<a href="/extras/main.php"><img src="/assets/img/window-apps-32.png" height="32px" alt=""/>Extras</a>
<a href="<?php echo "/settings/main.php?lat={$_GET['lat']}&amp;long={$_GET['long']}"; ?>"><img src="/assets/img/settings-5-32.png" height="32px" alt=""/>Settings</a>
</div>
<div class="column column2">
<p style="color:<?php echo $date_color . '">' . $now->format('d-m-Y'); ?></p>
<img style="margin:5px 0 0 0" src="/assets/img/widget-images/<?php echo $logo_setting; ?>.png" alt=""/>
<?php if (!empty($welcomemsg)) echo "<h1 style=\"color:{$message_color};margin-top:-5px\">{$welcomemsg}</h1>"; ?>
</div>
<?php
  if ($weather_data != "unavailable" && $weather_data != "error") {
    $weather_data = json_decode($weather_data);
    echo '<div style="margin-top:-10px" class="column column2">';
    echo '<p style="font-size:32px;display:inline-block;color:' . $message_color . '">' . $weather_data->now_temperature . ' ' . $weather_data->now_condition . '</p>';
    echo '<img style="display:inline-block;margin:0 0 14px 10px" height="32px" src="/assets/img/weather-64/' . str_replace(' ', '-', $weather_data->now_condition) . '.png" alt=""/>';
    echo '</div>';
  }
?>
</div> 
</body>
</html> 