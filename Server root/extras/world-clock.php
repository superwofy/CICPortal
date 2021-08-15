<?php
/*
Copyright (c) 2021 by fosd601 (https://codepen.io/asdfg44l/pen/LvoVaY)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? (ctype_alnum($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000") : "E000000";
$filename = $_SERVER["DOCUMENT_ROOT"].'/settings/vehicle/'.$VIN.'.json';
$settings = "";

if (file_exists($filename)) $settings = file_get_contents($filename);
else $settings = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/settings/vehicle/'.'E000000.json');

$settings = json_decode($settings);
$u_tz = $settings->timezone;
header("Content-type: application/xhtml+xml");

?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>CIC Portal >> World Clock</title>
<link href="/assets/css/clock.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<p id="debug"></p>
<p class="top-p">These values depend on the car time and portal timezone being set.</p>
<p id="u_tz" style="display:none"><?php echo $u_tz; ?></p>
<div class="container">
<table id="clkTbl" class="timeZone"><tr style="display:none"><td/></tr></table>
</div>
<script type="text/javascript" src="/assets/js/clock.js"></script>
</body>
</html>