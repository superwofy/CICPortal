<?php
header("Content-type: application/xhtml+xml");
ob_start("ob_gzhandler");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal > Settings</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"></link>'; ?>
<link href="/assets/css/main.css" type="text/css" rel="stylesheet"/>
</head>
<body style="margin-top:50px">
<div>
<div class="column">
<a href="./appearance-local.php"><img src="/assets/img/side-left-view-32.png" height="32px" alt=""/>Appearance/Locale</a>
<a href="./view-provisioning.php"><img src="/assets/img/code-32.png" height="32px" alt=""/>View Provisioning</a>
<a href="<?php echo "./info.php?lat={$_GET['lat']}&amp;long={$_GET['long']}"; ?>"><img src="/assets/img/info-2-32.png" height="32px" alt=""/>Portal Info</a>
<a href="" onclick="clear_cookies();"><img src="/assets/img/refresh-2-32.png" height="32px" alt=""/>Reset</a>
</div>
<div class="column column2"><img class="setting-icon" src="/assets/img/settings-5-256.png" alt="Settings"/></div>
</div> 
<script type="text/javascript">function clear_cookies(){document.cookie.split(";").forEach(function(e){document.cookie=e.replace(/^ +/,"").replace(/=.*/,"=;expires="+(new Date).toUTCString()+";path=/")}),location.reload()}</script>
</body>
</html> 