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

$weather_data = "error";
$weather_link = "/weather/index.php?lat=0&amp;long=0";
$settings_link = "/settings/index.php";
if (isset($_GET['lat']) && isset($_GET['long'])) {
  $weather_data = file_get_contents("http://127.0.0.1/weather/get-weather.php?lat={$_GET['lat']}&long={$_GET['long']}&VIN={$VIN}");
  $weather_link = "/weather/index.php?lat={$_GET['lat']}&amp;long={$_GET['long']}";
  $settings_link = "/settings/index.php?lat={$_GET['lat']}&amp;long={$_GET['long']}";
} 

include_once($_SERVER['DOCUMENT_ROOT'] . '/a/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>CIC Portal Home</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/a/css/default_bon.css" rel="stylesheet">'; ?>
<link href="/a/css/index.css" rel="stylesheet">
</head>
<body style="margin-top:10px">
<div>
<div class="column" style="margin-top:10px">
<a href="<?php echo $weather_link; ?>"><img src="/a/img/clouds.png" height="32px">Weather</a>
<a href="/news/index.php"><img src="/a/img/news.png" height="32px">News</a>
<a href="/search/index.php"><img src="/a/img/search.png" height="32px">Search</a>
<a href="/extras/index.php"><img src="/a/img/window.png" height="32px">Extras</a>
<a href="<?php echo $settings_link; ?>"><img src="/a/img/set.png" height="32px">Settings</a>
</div>
<div class="column column2">
<p style="color:<?php echo $date_color . '">' . $now->format('d-m-Y'); ?></p>
<img style="margin:5px 0 0 0" src="/a/img/widget/<?php echo $logo_setting; ?>.png">
<?php if (!empty($welcomemsg)) echo "<h1 style=\"color:{$message_color};margin-top:-5px\">{$welcomemsg}</h1>"; ?>
</div>
<?php
if ($weather_data != "unavailable" && $weather_data != "error") {
  $weather_data = json_decode($weather_data);
  echo '<div style="margin-top:-10px" class="column column2">';
  echo '<p style="font-size:32px;display:inline-block;color:' . $message_color . '">' . $weather_data->now_temperature . ' ' . $weather_data->now_condition . '</p>';
  echo '<img style="display:inline-block;margin:0 0 14px 10px" height="32px" src="/a/img/weather-64/' . str_replace(' ', '-', $weather_data->now_condition) . '.png">';
  echo '</div>';
}
?>
</div> 
</body>
</html> 