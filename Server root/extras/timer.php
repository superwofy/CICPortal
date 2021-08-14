<?php
header("Content-type: application/xhtml+xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal >> Timer</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet"/>'; ?>
<link href="/assets/css/timer.css" type="text/css" rel="stylesheet"/>
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
<table id="laps"><tr style="display:none"><td/></tr></table>
</div>
<script type="text/javascript" src="/assets/js/timer.js"></script>
</body>
</html> 