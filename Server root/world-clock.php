<?php
/*
Copyright (c) 2021 by fosd601 (https://codepen.io/asdfg44l/pen/LvoVaY)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/loadsettings.php');
$u_tz = $settings->timezone;
include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal >> World Clock</title>
<style type="text/css">body{background-color:#eee;color:#000}h3{font-size:42px}table{font-weight:700;width:100%;margin:0 20px 20px 20px;border:2px solid #000}.col{padding-left:30px;width:48%;float:left}.col2{font-size:70px;text-align:center;margin-left:3px;padding:30px 0 30px 0;width:47.8%}#tp{font-size:28px}.dark{color:#fff;background-color:#000}tr p{font-size:26px}</style></head>
<body>
<p id="tp">These values depend on the car time and portal timezone being set.</p>
<p id="u_tz" style="display:none"><?php echo $u_tz; ?></p>
<table id="t"><tr style="display:none"><td></td></tr></table>
<script src="/assets/js/clock.js" type="text/javascript"></script>
</body>
</html>