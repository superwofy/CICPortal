<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/a/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>CIC Portal > Settings</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/a/css/default_bon.css" rel="stylesheet">'; ?>
<link href="/a/css/index.css" rel="stylesheet">
</head>
<body style="margin-top:50px">
<div>
<div class="column">
<a href="./appearance-local.php"><img src="/a/img/side-left-view.png" height="32px">Appearance/Locale</a>
<a href="./view-provisioning.php"><img src="/a/img/code.png" height="32px">View Provisioning</a>
<a href="<?php echo "./info.php?lat={$_GET['lat']}&amp;long={$_GET['long']}"; ?>"><img src="/a/img/info-2.png" height="32px">Portal Info</a>
<a href="" onclick="clear_cookies();"><img src="/a/img/refresh-2.png" height="32px">Reset</a>
</div>
<div class="column column2"><img class="setting-icon" src="/a/img/settings-5-256.png"></div>
</div> 
<script src="/a/js/reset.js"></script>
</body>
</html> 