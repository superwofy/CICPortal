<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal > Settings</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
<link href="/assets/css/index.css" rel="stylesheet">
</head>
<body style="margin-top:50px">
<div>
<div class="col">
<a href="/settings-appearance-local.php"><img src="/assets/img/side-left-view.png" alt="">Appearance/Locale</a>
<a href="/view-provisioning.php"><img src="/assets/img/code.png" alt="">View Provisioning</a>
<a href="<?php echo "/info.php?lat={$_GET['lat']}&amp;long={$_GET['long']}"; ?>"><img src="/assets/img/info-2.png" alt="">Portal Info</a>
<a href="" onclick="clear_cookies();"><img src="/assets/img/refresh-2.png" alt="">Reset</a>
</div>
<div class="col col2"><img style="margin-top:25px" src="/assets/img/settings-5-256.png" alt=""></div>
</div> 
<script type="text/javascript">function clear_cookies(){document.cookie.split(";").forEach(function(e){document.cookie=e.replace(/^ +/,"").replace(/=.*/,"=;expires="+(new Date).toUTCString()+";path=/")}),location.reload()}</script>
</body>
</html> 