<?php

$lat = isset($_GET['lat']) ? (is_numeric($_GET['lat']) ? $_GET['lat'] : "0") : "0";
$long = isset($_GET['long']) ? (is_numeric($_GET['long']) ? $_GET['long'] : "0") : "0";
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000") : "E000000";

$weather_data = "unavailable";

if ($lat === "0" && $long === "0") {
	$weather_data = "error";
} else {
	$weather_data = file_get_contents("http://127.0.0.1/weather/get-weather.php?lat={$lat}&long={$long}&VIN={$VIN}");
}

header("Content-type: application/xhtml+xml");
ob_start("ob_gzhandler");
?>
<?php if ($weather_data == "unavailable") : ?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal >> Weather Unavailable</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
</head>
<body>
<p style="text-align:center;margin-top:150px">Weather data unavailable for this location!</p>
</body>
</html>

<?php elseif ($weather_data == "error") : ?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal >> Weather Error</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
</head>
<body>
<p style="text-align:center;margin-top:150px">Failed to retrieve weather data!</p>
</body>
</html>

<?php else : ?>
<?php $weather_data = json_decode($weather_data); ?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal > Weather</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
<link href="/assets/css/weather.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<h1><?php echo $weather_data->forecast_header_value; ?></h1>
<table>
<tr class="heading">
<th>Morning</th>
<th>Afternoon</th> 
<th>Evening</th>
<th class="nobr">Overnight</th>
</tr>
<tr>
<td class="temp"><?php echo $weather_data->today_morning_temperature; ?></td>
<td class="temp"><?php echo $weather_data->today_afternoon_temperature; ?></td>
<td class="temp"><?php echo $weather_data->today_evening_temperature; ?></td>
<td class="temp nobr"><?php echo $weather_data->today_overnight_temperature; ?></td>
</tr>
<tr>
<td><img src="/assets/img/weather-col/<?php echo str_replace(' ', '-', $weather_data->today_morning_condition); ?>.png" alt=""/></td>
<td><img src="/assets/img/weather-col/<?php echo str_replace(' ', '-', $weather_data->today_afternoon_condition); ?>.png"  alt=""/></td>
<td><img src="/assets/img/weather-col/<?php echo str_replace(' ', '-', $weather_data->today_evening_condition); ?>.png"  alt=""/></td>
<td class="nobr"><img src="/assets/img/weather-col/<?php echo str_replace(" ", '-', $weather_data->today_overnight_condition); ?>.png" alt=""/></td>
</tr>
<tr>
<td><?php echo $weather_data->today_morning_condition; ?></td>
<td><?php echo $weather_data->today_afternoon_condition; ?></td>
<td><?php echo str_replace(" Night", '', $weather_data->today_evening_condition); ?></td>
<td class="nobr"><?php echo str_replace(" Night", '', $weather_data->today_overnight_condition); ?></td>
</tr>
<tr>
<td><?php echo $weather_data->today_morning_precipitation; ?></td>
<td><?php echo $weather_data->today_afternoon_precipitation; ?></td>
<td><?php echo $weather_data->today_evening_precipitation; ?></td>
<td class="nobr"><?php echo $weather_data->today_overnight_precipitation; ?></td>
</tr>
</table>
<h1>Hourly Forecast</h1>
<table>
<tr class="heading">
<th>Now</th>
<th><?php echo $weather_data->one_hour_heading; ?></th> 
<th><?php echo $weather_data->two_hours_heading; ?></th>
<th class="nobr"><?php echo $weather_data->three_hours_heading; ?></th>
</tr>
<tr>
<td class="temp"><?php echo $weather_data->now_temperature; ?></td>
<td class="temp"><?php echo $weather_data->one_hour_temperature; ?></td>
<td class="temp"><?php echo $weather_data->two_hours_temperature; ?></td>
<td class="temp nobr"><?php echo $weather_data->three_hours_temperature; ?></td>
</tr>
<tr>
<td><img src="/assets/img/weather-col/<?php echo str_replace(' ', '-', $weather_data->now_condition); ?>.png" alt=""/></td>
<td><img src="/assets/img/weather-col/<?php echo str_replace(' ', '-', $weather_data->one_hour_condition); ?>.png" alt=""/></td>
<td><img src="/assets/img/weather-col/<?php echo str_replace(' ', '-', $weather_data->two_hours_condition); ?>.png" alt=""/></td>
<td class="nobr"><img src="/assets/img/weather-col/<?php echo str_replace(' ', '-', $weather_data->three_hours_condition); ?>.png" alt=""/></td>
</tr>
<tr>
<td><?php echo $weather_data->now_condition; ?></td>
<td><?php echo $weather_data->one_hour_condition; ?></td>
<td><?php echo $weather_data->two_hours_condition; ?></td>
<td class="nobr"><?php echo $weather_data->three_hours_condition; ?></td>
</tr>
<tr>
<td><?php echo $weather_data->now_precipitation; ?></td>
<td><?php echo $weather_data->one_hour_precipitation; ?></td>
<td><?php echo $weather_data->two_hours_precipitation; ?></td>
<td class="nobr"><?php echo $weather_data->three_hours_precipitation; ?></td>
</tr>
</table>
<div class="info">
<h1>Extra</h1>
<?php if($weather_data->map_phrase) echo '<p>' . $weather_data->map_phrase . '</p>'; ?>
<p><?php echo 'The sun rises at ' . $weather_data->sunrise_time . ' and sets at ' . $weather_data->sunset_time . ' today.'; ?></p>
<p><?php echo $weather_data->air_quality; ?></p>
</div>
</body>
</html> 
<?php endif; ?>