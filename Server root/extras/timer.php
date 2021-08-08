<!DOCTYPE html>
<html>
<head>
<title>CIC Portal >> Timer</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
<style>button{display:block;width:170px;margin-top:8px;margin-left:112px;font-size:32px}button:focus{border:medium solid #fc3c00}body{margin-top:20px}.column{float:left;width:50%;text-align:center}#laps{width:100%;border:1px solid #fff}.tcontainer{font-size:80px;margin-top:10px}</style>
</head>
<body>
<div class="row">
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
<table id="laps"></table>
</div>
<script>
var min=0;var sec=0;var ms=0;var lap=1;var timer;var paused=true;var laptable=document.getElementById("laps");

function t_start_pause(){
if(paused){
clearInterval(timer);
timer=setInterval(ltimer,100);
paused=false;
}else{pause();}
}
function pause(){clearInterval(timer);paused=true;}
function t_reset(){
min=sec=ms=0;
document.getElementById('min').innerText=document.getElementById('sec').innerText='00';document.getElementById('ms').innerText='0';
}
function t_clear(){
if(!paused){pause();}
t_reset();
lap=1;
laptable.innerHTML="";
}
function t_lap(){
if(lap>5){laptable.innerHTML="";lap=1;}
var row=laptable.insertRow(0);
var cell1=row.insertCell(0);
cell1.innerHTML='Lap #'+lap+' - '+min+":"+sec+":"+(ms/100);
lap++;
t_reset();
}
function returnData(input){return input>9 ? input : '0'+input;}
function ltimer(){
if((ms+=100)==1000){ms=0;sec++;}
if(sec==60){sec=0;min++;document.getElementById('min').innerHTML = returnData(min);}
if(min==60){min=0;}
document.getElementById('sec').innerHTML = returnData(sec);
document.getElementById('ms').innerHTML = ms/100;
}
</script>
</body>
</html> 