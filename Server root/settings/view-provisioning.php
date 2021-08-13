<?php
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
$VIN = ctype_alnum($VIN) ? $VIN : "E000000";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/provision.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$XML = curl_exec($ch);

header("Content-type: application/xhtml+xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<style type="text/css">pre{font-size:20px;line-height:initial;margin-left:15px}</style>
<title>CIC Portal >> Provisioning</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
</head>
<body>
<?php echo '<pre>'.htmlspecialchars($XML).'</pre>'; ?>
</body>
</html>