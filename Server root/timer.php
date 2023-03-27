<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal >> Timer</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
<style type="text/css">button{background-color:#333;color:#fff;display:block;width:250px;margin-top:8px;margin-left:70px;font-size:36px}button:focus{border:medium solid #fc3c00}body{margin-top:30px}.col{float:left;width:50%;text-align:center}#laps{width:100%;border:1px solid #fff}.tc{font-size:110px;margin-bottom:20px}table{padding-left:20px}</style>
</head>
<body>
<div class="col">
<div class="tc">
<span id="min">00</span>:<span id="sec">00</span>:<span id="ms">0</span>
</div>
<button type="button" onclick="t_start_pause();" name="start">Start/Stop</button>
<button type="button" onclick="t_lap();" name="start">Lap</button>
<button type="button" onclick="t_reset();" name="reset">Reset</button>
<button type="button" onclick="t_clear();" name="reset">Clear All</button>
</div>
<div class="col">
<table id="laps"><tr style="display:none"><td></td></tr></table>
</div>
<script src="/assets/js/timer.js" type="text/javascript"></script>
</body>
</html> 