<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/provision.php?portal=true");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$XML = curl_exec($ch);

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal >> Provisioning</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
</head>
<body>
<?php echo '<pre style="font-size:20px;line-height:25px;margin-left:15px">'.htmlspecialchars($XML).'</pre>'; ?>
</body>
</html>