<?php


$lat = $_GET['lat'];
$long = $_GET['long'];

//TESTING - this is the format sent by the CIC
// $lat = '525200000';
// $long = '134000000';

$lat = str_split(str_split($lat, 4)[0], 2);
$lat = $lat[0] . '.' . $lat[1];

$long = str_split(str_split($long, 4)[0], 2);
$long = $long[0] . '.' . $long[1];


$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
$VIN = ctype_alnum($VIN) ? $VIN : "E000000";

$weather_data = file_get_contents("http://127.0.0.1/weather/get-weather.php?lat={$lat}&long={$long}&VIN={$VIN}");

?>

<?php if ($weather_data == "failed") : ?>

<!DOCTYPE html>
<html>
<head>
<title>CIC Portal >> Weather Error</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
</head>
<body>
<p style="text-align:center;margin-top:150px">Weather data unavailable for this location!</p>
<p style="text-align:center"><?php echo $lat . ', ' . $long; ?></p>
</body>
</html> 

<?php else : ?>

<?php $weather_data = json_decode($weather_data); ?>

<!DOCTYPE html>
<html>
<head>
<title>CIC Portal > Weather</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
<style>table{table-layout:fixed;width:100%;border-spacing:0}h1{margin-bottom:20px;font-size:30px;text-align:center}td{font-size:22px;border-right:3px solid #494949}th{border-right:3px solid #494949}tr{text-align:center}.heading{font-size:28px}.temp{font-size:36px}.nobr{border:0}p{font-size:28px;line-height:40px}</style>
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
<td><img src="/assets/img/weather-64/<?php echo $weather_data->today_morning_condition; ?>.png"></td>
<td><img src="/assets/img/weather-64/<?php echo $weather_data->today_afternoon_condition; ?>.png"></td>
<td><img src="/assets/img/weather-64/<?php echo $weather_data->today_evening_condition; ?>.png"></td>
<td class="nobr"><img src="/assets/img/weather-64/<?php echo $weather_data->today_overnight_condition; ?>.png"></td>
</tr>
<tr>
<td><?php echo $weather_data->today_morning_condition; ?></td>
<td><?php echo $weather_data->today_afternoon_condition; ?></td>
<td><?php echo $weather_data->today_evening_condition; ?></td>
<td class="nobr"><?php echo $weather_data->today_overnight_condition; ?></td>
</tr>
<tr>
<td><?php echo $weather_data->today_morning_precipitation; ?></td>
<td><?php echo $weather_data->today_afternoon_precipitation; ?></td>
<td><?php echo $weather_data->today_evening_precipitation; ?></td>
<td class="nobr"><?php echo $weather_data->today_overnight_precipitation; ?></td>
</tr>
</table>
<br>
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
<td><img src="/assets/img/weather-64/<?php echo $weather_data->now_condition; ?>.png"></td>
<td><img src="/assets/img/weather-64/<?php echo $weather_data->one_hour_condition; ?>.png"></td>
<td><img src="/assets/img/weather-64/<?php echo $weather_data->two_hours_condition; ?>.png"></td>
<td class="nobr"><img src="/assets/img/weather-64/<?php echo $weather_data->three_hours_condition; ?>.png"></td>
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
<br>
<div class="info">
<h1>Extra</h1>
<p><?php echo $weather_data->map_phrase; ?></p>
<p><?php echo 'The sun rises at ' . $weather_data->sunrise_time . ' and sets at ' . $weather_data->sunset_time . ' today.'; ?></p>
<p><?php echo $weather_data->air_quality; ?></p>
</div>
</body>
</html> 

<?php endif; ?>