<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/loadsettings.php');

$welcomemsg = $settings->welcomemsg;
$message_color = $settings->message_color;
$date_color = $settings->date_color;
$logo_setting = $settings->logo_setting;
$timezone = $settings->timezone;
$country = $settings->country;
$language = $settings->language;

$colors = array("Default Color" => "#80B0DC", "White" => "white", "Red" => "red", "Green" => "green", "Orange" => "orange", "Pink" => "pink");
$images = array("Black and White" => "0", "Blue Transparent" => "1", "Vintage Logo (slower)" => "2", "///M Logo" => "3");
$countries = array("UK" => "UK", "USA" => "US", "Ireland" => "IE", "Deutschland" => "DE", "España" => "ES", "România" => "RO");
$languages = array("English" => "en", "Deutsch" => "de", "Français" => "fr", "Español" => "es", "Română" => "ro");
$timezones = array("+8" => "8", "+7" => "7", "+6" => "6", "+5" => "5", "+4" => "4", "+3" => "3", "+2" => "2", "+1" => "1", "0" => "0", "-1" => "-1", "-2" => "-2", "-3" => "-3", "-4" => "-4", "-5" => "-5", "-6" => "-6", "-7" => "-7", "-8" => "-8");

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal >> Appearance</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
<style type="text/css">body{font-size:32px;text-align:center;line-height:50px}p{margin:20px 0 20px 0}input[type=text]{padding-left:20px}select{padding-left:20px;width:43%}input[type=submit]{margin:20px 0 20px 0}</style>
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
<p><label>News Language</label></p>
<div>
<select name="language-setting">
<?php
foreach ($languages as $key => $value){
    if ($value == $language){
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