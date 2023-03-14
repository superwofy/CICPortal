<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/a/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>CIC Portal > Extras</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/a/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
<link href="/a/css/index.css" type="text/css" rel="stylesheet">
</head>
<body style="margin-top:80px">
<div>
<div class="column">
<a href="./timer.php"><img src="/a/img/timer.png" height="32px">Lap Timer</a>
<a href="./world-clock.php"><img src="/a/img/time-8.png" height="32px">World Clock</a>
</div>
<div class="column column2"><img class="extras-icon" src="/a/img/window-apps-256.png"></div>
</div>
</body>
</html> 