<?php

if (!empty($_POST)) {
	$saved = true;
	$settings = new stdClass();
	$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
	$VIN = ctype_alnum($VIN) ? $VIN : "E000000";
	$settings->welcomemsg = isset($_POST['welcomemsg']) ? $_POST['welcomemsg'] : "";
	$settings->message_color = isset($_POST['welcomemsg-color']) ? $_POST['welcomemsg-color'] : "#80B0DC";
	$settings->date_color = isset($_POST['date-color']) ? $_POST['date-color'] : "#80B0DC";
	$settings->logo_setting = isset($_POST['logo-setting']) ? $_POST['logo-setting'] : "1";
	$settings->country = isset($_POST['country-setting']) ? $_POST['country-setting'] : "uk";
	$settings->timezone = isset($_POST['timezone']) ? $_POST['timezone'] : "0";
	$fp = fopen(getcwd().'/vehicle/'.$VIN.'.json', 'w');
	if (!$fp) failure();
	$written = fwrite($fp, json_encode($settings));
	if (!$written) failure();
	fclose($fp);
}

function failure(){
	echo "Failed to save settings.";
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
<title>CIC Portal >>> Settings saved</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
</head>
<body>
<p style="text-align:center;margin-top:150px">Settings saved successfully!</p>
</body>
</html> 