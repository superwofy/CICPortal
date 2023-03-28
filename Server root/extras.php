<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal > Extras</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
<link href="/assets/css/index.css" rel="stylesheet">
</head>
<body style="margin-top:80px">
<div>
<div class="col">
<a href="/timer.php"><img src="/assets/img/timer.png" alt="">Lap Timer</a>
<a href="/world-clock.php"><img src="/assets/img/time-8.png" alt="">World Clock</a>
<a href="/slideshow.php"><img src="/assets/img/photos.png" alt="">Slideshow</a>
</div>
<div class="col col2"><img src="/assets/img/window-apps-256.png" alt=""></div>
</div>
</body>
</html> 