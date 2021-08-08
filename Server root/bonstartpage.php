<?php

$lat = isset($_GET['lat']) ? $_GET['lat'] : "0";
$long = isset($_GET['long']) ? $_GET['long'] : "0";
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
$VIN = ctype_alnum($VIN) ? $VIN : "E000000";
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

?>

<!DOCTYPE html>
<html>
<head>
<title>CIC Portal Home</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
<style>a:focus{border:3px solid #fc3c00;margin:-3px -3px -3px -3px}a:link,a:visited{display:block;width:100%}a:visited img{border:none;background-color:initial}li{margin:8px;border:3px solid #494949}li>a:focus{color:#fff}img{border:none;margin:0 30px -5px 30px}ul{list-style:none;padding-left:0}.column{float:left;width:50%}.column2{text-align:center}body{margin-top:20px}</style>
</head>
<body>
<div>
<div class="column">
<ul>
<li><a href="<?php echo "/weather/main.php?lat={$lat}&long={$long}"; ?>"><img src="/assets/img/clouds-32.png" height="32px"/>Weather</a></li>
<li><a href="/news/index.php"><img src="/assets/img/newspaper-32.png" height="32px"/>News</a></li>
<li><a href="/search/index.php"><img src="/assets/img/search-3-32.png" height="32px"/>Search</a></li>
<li><a href="/extras/main.php"><img src="/assets/img/window-apps-32.png" height="32px"/>Extras</a></li>
<li><a href="<?php echo "/settings/main.php?lat={$lat}&long={$long}"; ?>"><img src="/assets/img/settings-5-32.png" height="32px"/>Settings</a></li>
</ul>
</div>
<div class="column column2">
<p style="color:<?php echo $date_color; ?>"><?php echo $now->format('d-m-Y'); ?></p>
<img style="margin:10px 0 0 0" src="/assets/img/widget-images/<?php echo $logo_setting; ?>.png"/>
<?php if (!empty($welcomemsg)) echo "<h1 style=\"color:{$message_color}\">{$welcomemsg}</h1>"; ?>
</div>
</div> 
</body>
</html> 