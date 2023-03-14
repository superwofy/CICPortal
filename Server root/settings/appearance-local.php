<?php

$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000") : "E000000";
$filename = getcwd().'/vehicle/'.$VIN.'.json';

if (!preg_match('/^' . str_replace('/', "\/", getcwd()) . "\/vehicle\/[A-Z|0-9]{7}.json$/", $filename))      //attempt to prevent directory traversal with $VIN
    exit();

$settings = "";

if (file_exists($filename)) $settings = file_get_contents($filename);
else $settings = file_get_contents(getcwd().'/vehicle/'.'E000000.json');

$settings = json_decode($settings);

$welcomemsg = $settings->welcomemsg;
$message_color = $settings->message_color;
$date_color = $settings->date_color;
$logo_setting = $settings->logo_setting;
$timezone = $settings->timezone;
$country = $settings->country;

$colors = array("Default Color" => "#80B0DC", "White" => "white", "Red" => "red", "Green" => "green", "Orange" => "orange", "Pink" => "pink");
$images = array("Black and White" => "0", "Blue Transparent" => "1", "Vintage Logo (slower)" => "2", "///M Logo" => "3");
$countries = array("UK" => "UK", "USA" => "US", "Ireland" => "IE", "Germany" => "DE", "France" => "FR");
$timezones = array("+8" => "8", "+7" => "7", "+6" => "6", "+5" => "5", "+4" => "4", "+3" => "3", "+2" => "2", "+1" => "1", "0" => "0", "-1" => "-1", "-2" => "-2", "-3" => "-3", "-4" => "-4", "-5" => "-5", "-6" => "-6", "-7" => "-7", "-8" => "-8");

include_once($_SERVER['DOCUMENT_ROOT'] . '/a/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>CIC Portal >> Appearance</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/a/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
<link href="/a/css/appearance.css" type="text/css" rel="stylesheet">
</head>
<body>

<form action="./save-settings.php" method="post">
<p><label for="welcomemsg">Welcome Message</label></p>
<div><input type="text" id="welcomemsg" name="welcomemsg" value="<?php echo $welcomemsg; ?>"></div>
<p><label>Welcome Message Color</label></p>
<div>
<select name="welcomemsg-color" id="welcomemsg-color">
<?php
foreach ($colors as $key => $value){
    if ($value == $message_color){
    	$selected = 'selected="selected"'; 
    } else {
    	$selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select>
</div>
<p><label>Home Date Color</label></p>
<div>
<select name="date-color">
<?php
foreach ($colors as $key => $value){
    if ($value == $date_color){
    	$selected = 'selected="selected"'; 
    } else {
    	$selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select>
</div>
<p><label>Home Sidebar Logo</label></p>
<div>
<select name="logo-setting">
<?php
foreach ($images as $key => $value){
    if ($value == $logo_setting){
    	$selected = 'selected="selected"'; 
    } else {
    	$selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select>
</div>
<p><label>News Country</label></p>
<div>
<select name="country-setting">
<?php
foreach ($countries as $key => $value){
    if ($value == $country){
        $selected = 'selected="selected"'; 
    } else {
        $selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select>
</div>
<p><label>Clock Timezone (UTC)</label></p>
<div>
<select name="timezone">
<?php
foreach ($timezones as $key => $value){
    if ($value == $timezone){
        $selected = 'selected="selected"'; 
    } else {
        $selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select>
</div>
<div><input type="submit" value=" Save Settings "></div>
</form>
</body>
</html> 