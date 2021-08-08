<?php
/*
Copyright (c) 2021 by fosd601 (https://codepen.io/asdfg44l/pen/LvoVaY)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
$VIN = ctype_alnum($VIN) ? $VIN : "E000000";
$filename = $_SERVER["DOCUMENT_ROOT"].'/settings/vehicle/'.$VIN.'.json';
$settings = "";

if (file_exists($filename)) $settings = file_get_contents($filename);
else $settings = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/settings/vehicle/'.'E000000.json');

$settings = json_decode($settings);
$u_tz = $settings->timezone;

?>
<!DOCTYPE html>
<html>
<head>
<title>CIC Portal >> World Clock</title>
<style>body{background-color:#eee;color:#000}h3{font-size:42px}table{width:100%;margin:20px;border:2px solid #000}.column{padding-left:10px;width:50%;float:left}.column2{font-size:70px;text-align:center;margin-left:3px;padding:30px 0 30px 0;width:47.8%}.top-p{font-size:28px;margin:15px 0 0 10px}.bg_dark{color:#fff;background-color:#000}.container{font-weight:700;margin:10px}.timeZone p{font-size:26px;font-style:italic}</style>
</head>
<body>
<p id="debug"></p>
<p class="top-p">These values depend on the car time and portal timezone being set.</p>
<p id="u_tz" style="display:none"><?php echo $u_tz; ?></p>
<div class="container">
<table id="clkTbl" class="timeZone">
</table>
</div>
<script>
var data=[{city:"NEW YORK",tz:-4,},{city:"LONDON",tz:1},{city:"PARIS",tz:2},{city:"TOKYO",tz:9},{city:"SYDNEY",tz:10}];
var timeTable=document.getElementById('clkTbl');
var u_tz=parseInt((document.getElementById('u_tz')).innerHTML,10);
function clockMaker(){
timeTable.innerHTML='';
var now=new Date();
for(var i=0;i<data.length;i++){
var c_time=now.getTime()+(u_tz*-3600000)+(data[i].tz*3600000);
var loc_now=new Date(c_time);
var splice=(loc_now.toLocaleString('en')).split(', ');
var day=splice[1].split(' ')[1];var month=splice[1].split(' ')[0];var year=splice[2].split(' ')[0];
var time_sec=splice[2].split(' ')[1]
var time=time_sec.split(':')[0]+':'+time_sec.split(':')[1];
var tr=document.createElement('tr');
var rowclass="";
if(i%2==0){rowclass="bg_dark";}
tr.innerHTML='<div><div class="'+rowclass+' column"><h3>'+data[i].city+'</h3><p>'+day+' '+month+','+year+'</p></div><div class="'+rowclass+' column column2">'+time+'</div></div>';
timeTable.appendChild(tr);
}}
clockMaker();
setInterval(clockMaker,10000);
</script>
</body>
</html> 