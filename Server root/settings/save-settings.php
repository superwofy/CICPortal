<?php

$message = "Failed to save settings!";

if (!empty($_POST)) {
	$saved = true;
	$settings = new stdClass();
	$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($VIN) ? $VIN : "E000000") : "E000000";
	$settings->welcomemsg = isset($_POST['welcomemsg']) ? $_POST['welcomemsg'] : "";
	$settings->message_color = isset($_POST['welcomemsg-color']) ? $_POST['welcomemsg-color'] : "#80B0DC";
	$settings->date_color = isset($_POST['date-color']) ? $_POST['date-color'] : "#80B0DC";
	$settings->logo_setting = isset($_POST['logo-setting']) ? $_POST['logo-setting'] : "1";
	$settings->country = isset($_POST['country-setting']) ? $_POST['country-setting'] : "uk";
	$settings->timezone = isset($_POST['timezone']) ? $_POST['timezone'] : "0";
	$fp = fopen(getcwd().'/vehicle/'.$VIN.'.json', 'w');
	if ($fp) {
		$written = fwrite($fp, json_encode($settings));
		if ($written) {
			$message = "Settings saved successfully!";
			fclose($fp);
		}
	}
}

header("Content-type: application/xhtml+xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal >>> Settings saved</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
</head>
<body>
<p style="text-align:center;margin-top:150px"><?php echo $message; ?></p>
</body>
</html>