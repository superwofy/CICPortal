<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/a/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>CIC Portal >> Timer</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/a/css/default_bon.css" rel="stylesheet">'; ?>
<link href="/a/css/timer.css" rel="stylesheet">
</head>
<body>
<div class="column">
<div class="tcontainer">
<span id="min">00</span>:<span id="sec">00</span>:<span id="ms">0</span>
</div>
<button type="button" onclick="t_start_pause();" name="start">Start/Stop</button>
<button type="button" onclick="t_lap();" name="start">Lap</button>
<button type="button" onclick="t_reset();" name="reset">Reset</button>
<button type="button" onclick="t_clear();" name="reset">Clear All</button>
</div>
<div class="column">
<table id="laps"><tr style="display:none"><td></td></tr></table>
</div>
<script src="/a/js/timer.js"></script>
</body>
</html> 