<?php
header("Content-type: application/xhtml+xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal > Extras</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
<style type="text/css">body{margin-top:80px}ul{list-style:none;padding-left:0}a:focus{border:3px solid #fc3c00;margin:-3px -3px -3px -3px}a:link,a:visited{display:block;width:100%}a:visited img{border:none}li{margin:8px;border:3px solid #494949}li>a:focus{color:#fff}img{border:none;margin:0 30px -5px 30px}.column{float:left;width:50%}.column2{text-align:center}.extras-icon{margin:-15px 0 0 0}</style>
</head>
<body>
<div>
<div class="column">
<ul>
<li><a href="./timer.php"><img src="/assets/img/timer-32.png" height="32px" alt=""/>Lap Timer</a></li>
<li><a href="./world-clock.php"><img src="/assets/img/time-8-32.png" height="32px" alt=""/>World Clock</a></li>
</ul>
</div>
<div class="column column2"><img class="extras-icon" src="/assets/img/window-apps-256.png" alt="Extras"/></div>
</div>
</body>
</html> 