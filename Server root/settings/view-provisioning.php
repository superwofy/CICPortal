<?php
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
$VIN = ctype_alnum($VIN) ? $VIN : "E000000";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/provision.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$XML = curl_exec($ch);
?>
<!DOCTYPE html>
<html>
<head>
<title>CIC Portal >> Provisioning</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
</head>
<body>
<?php echo '<pre style="font-size:20px;line-height:initial;margin-left:15px">'.htmlspecialchars($XML).'</pre>'; ?>
</body>
</html>2048