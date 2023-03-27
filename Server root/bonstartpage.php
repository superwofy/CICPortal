<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/loadsettings.php');

$welcomemsg = $settings->welcomemsg;
$message_color = $settings->message_color;
$date_color = $settings->date_color;
$logo_setting = $settings->logo_setting;
$timezone = $settings->timezone;

$now = new DateTime();

$weather_data = "error";
$weather_link = "/weather.php?lat=0&amp;long=0";
$settings_link = "/settings.php";
if (isset($_GET['lat']) && isset($_GET['long'])) {
  $weather_data = file_get_contents("http://127.0.0.1/assets/php/get-weather.php?lat={$_GET['lat']}&long={$_GET['long']}&VIN={$VIN}");
  $weather_link = "/weather.php?lat={$_GET['lat']}&amp;long={$_GET['long']}";
  $settings_link = "/settings.php?lat={$_GET['lat']}&amp;long={$_GET['long']}";
} 

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal Home</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
<link href="/assets/css/index.css" rel="stylesheet">
</head>
<body style="margin-top:10px">
<div>
<div class="column" style="margin-top:10px">
<a href="<?php echo $weather_link; ?>"><img src="/assets/img/clouds.png" alt="">Weather</a>
<a href="/news.php"><img src="/assets/img/news.png" alt="">News</a>
<a href="/search.php"><img src="/assets/img/search.png" alt="">Search</a>
<a href="/extras.php"><img src="/assets/img/window.png" alt="">Extras</a>
<a href="<?php echo $settings_link; ?>"><img src="/assets/img/set.png" alt="">Settings</a>
</div>
<div class="column column2">
<?php echo '<p style="color:' . $date_color . '">' . $now->format('d-m-Y') . '</p>'; ?>
<img style="margin:5px 0 0 0" src="/assets/img/widget/<?php echo $logo_setting; ?>.png" alt="">
<?php if (!empty($welcomemsg)) echo "<h1 style=\"color:{$message_color};margin-top:-5px\">{$welcomemsg}</h1>"; ?>
</div>
<?php
if ($weather_data != "unavailable" && $weather_data != "error") {
  $weather_data = json_decode($weather_data);
  echo '<div style="margin-top:-10px" class="column column2">';
  echo '<p style="font-size:32px;display:inline-block;color:' . $message_color . '">' . $weather_data->now_temperature . ' ' . $weather_data->now_condition . '</p>';
  echo '<img style="display:inline-block;margin:0 0 14px 10px" height="32px" src="/assets/img/weather-64/' . str_replace(' ', '-', $weather_data->now_condition) . '.png" alt="">';
  echo '</div>';
}
?>
</div> 
</body>
</html> 