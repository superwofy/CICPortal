<?php
$lat = isset($_GET['lat']) ? $_GET['lat'] : "0";
$long = isset($_GET['long']) ? $_GET['long'] : "0";
header("Content-type: application/xhtml+xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal > Settings</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"></link>'; ?>
<style type="text/css">body{margin-top:50px}ul{list-style:none;padding-left:0}a{border:2px solid #494949;margin:8px;color:#FFFFFD}a:focus{border-color:#FC3C00}a:active,a:active img{background-color:#0d0d0d}a:link,a:visited{display:block;width:100%}a:visited img{border:none}img{border:none;margin:0 30px -5px 30px}.column{margin-left:2%;float:left;width:48%}.column2{text-align:center}.setting-icon{margin-top:25px}</style>
</head>
<body>
<div>
<div class="column">
<a href="./appearance-local-settings.php"><img src="/assets/img/side-left-view-32.png" height="32px" alt=""/>Appearance/Local</a>
<a href="./view-provisioning.php"><img src="/assets/img/code-32.png" height="32px" alt=""/>View Provisioning</a>
<a href="<?php echo "./info.php?lat={$lat}&amp;long={$long}"; ?>"><img src="/assets/img/info-2-32.png" height="32px" alt=""/>Portal Info</a>
<a href="" onclick="clear_cookies();"><img src="/assets/img/refresh-2-32.png" height="32px" alt=""/>Reset</a>
</div>
<div class="column column2"><img class="setting-icon" src="/assets/img/settings-5-256.png" alt="Settings"/></div>
</div> 
<script type="text/javascript">function clear_cookies(){document.cookie.split(";").forEach(function(e){document.cookie=e.replace(/^ +/,"").replace(/=.*/,"=;expires="+(new Date).toUTCString()+";path=/")}),location.reload()}</script>
</body>
</html> 