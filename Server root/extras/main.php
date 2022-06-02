<?php 
header("Content-type: application/xhtml+xml");
ob_start("ob_gzhandler");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal > Extras</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
<link href="/assets/css/main.css" type="text/css" rel="stylesheet"/>
</head>
<body style="margin-top:80px">
<div>
<div class="column">
<a href="./timer.php"><img src="/assets/img/timer-32.png" height="32px" alt=""/>Lap Timer</a>
<a href="./world-clock.php"><img src="/assets/img/time-8-32.png" height="32px" alt=""/>World Clock</a>
</div>
<div class="column column2"><img class="extras-icon" src="/assets/img/window-apps-256.png" alt=""/></div>
</div>
</body>
</html> 