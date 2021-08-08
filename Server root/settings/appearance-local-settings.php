<?php

$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
$VIN = ctype_alnum($VIN) ? $VIN : "E000000";
$filename = getcwd().'/vehicle/'.$VIN.'.json';
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
$images = array("Default Logo" => "1", "Vintage Logo" => "2");
$countries = array("UK" => "uk", "USA" => "us");
$timezones = array("+8" => "8", "+7" => "7", "+6" => "6", "+5" => "5", "+4" => "4", "+3" => "3", "+2" => "2", "+1" => "1", "0" => "0", "-1" => "-1", "-2" => "-2", "-3" => "-3", "-4" => "-4", "-5" => "-5", "-6" => "-6", "-7" => "-7", "-8" => "-8");

?>
<!DOCTYPE html>
<html>
<head>
<title>CIC Portal >> Appearance</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
<style>body{font-size:32px;text-align:center;line-height:50px}label{margin-top:20px}input[type=text]{padding-left:20px}select{padding-left:20px;width:43%}input[type=submit]{margin:20px 0 20px 0}</style>
</head>
<body>
<br>
<form action="./save-settings.php" method="post">
<label for="welcomemsg">Welcome Message</label><br>
<input type="text" id="welcomemsg" name="welcomemsg" value="<?php echo $welcomemsg; ?>"><br><br>
<label for="welcomemsg">Welcome Message color</label><br>
<select name="welcomemsg-color" id="welcomemsg-color">
<?php
foreach ($colors as $key => $value){
    if ($value == $message_color){
    	$selected = 'selected'; 
    } else {
    	$selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select><br><br>
<label for="date-color">Date color</label><br>
<select name="date-color">
<?php
foreach ($colors as $key => $value){
    if ($value == $date_color){
    	$selected = 'selected'; 
    } else {
    	$selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select><br><br>
<label for="logo-setting"> Right sidebar logo</label><br>
<select name="logo-setting">
<?php
foreach ($images as $key => $value){
    if ($value == $logo_setting){
    	$selected = 'selected'; 
    } else {
    	$selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select><br><br>
<label for="country-setting"> Country</label><br>
<select name="country-setting">
<?php
foreach ($countries as $key => $value){
    if ($value == $country){
        $selected = 'selected'; 
    } else {
        $selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select><br><br>
<label for="timezone"> Timezone</label><br>
<select name="timezone">
<?php
foreach ($timezones as $key => $value){
    if ($value == $timezone){
        $selected = 'selected'; 
    } else {
        $selected = "";
    }    
    echo "<option {$selected} value=\"{$value}\">{$key}</option>";
}
?>
</select><br><br>
<input type="submit" value=" Save Settings "><br>
</form>
</body>
</html> 