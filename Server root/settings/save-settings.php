<?php

$message = "Failed to save settings!";

if (!empty($_POST)) {
	$saved = true;
	$settings = new stdClass();
	$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000") : "E000000";
	if ($VIN === "E000000") {
		$message = "Cannot overwrite default file!";
	} 
	else {
		$settings->welcomemsg = isset($_POST['welcomemsg']) ? $_POST['welcomemsg'] : "";
		$settings->message_color = isset($_POST['welcomemsg-color']) ? $_POST['welcomemsg-color'] : "#80B0DC";
		$settings->date_color = isset($_POST['date-color']) ? $_POST['date-color'] : "#80B0DC";
		$settings->logo_setting = isset($_POST['logo-setting']) ? $_POST['logo-setting'] : "1";
		$settings->country = isset($_POST['country-setting']) ? $_POST['country-setting'] : "UK";
		$settings->timezone = isset($_POST['timezone']) ? $_POST['timezone'] : "0";

		$filename = getcwd().'/vehicle/'.$VIN.'.json';
		
		if (!preg_match('/^' . str_replace('/', "\/", getcwd()) . "\/vehicle\/[A-Z|0-9]{7}.json$/", $filename))      //attempt to prevent directory traversal with $VIN
		    exit();

		$fp = fopen(getcwd().'/vehicle/'.$VIN.'.json', 'w');
		if ($fp) {
			$written = fwrite($fp, json_encode($settings));
			if ($written) {
				$message = "Settings saved successfully!";
				fclose($fp);
			}
		}
	}
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/a/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>CIC Portal >>> Settings saved</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/a/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
</head>
<body>
<p style="text-align:center;margin-top:150px"><?php echo $message; ?></p>
</body>
</html>