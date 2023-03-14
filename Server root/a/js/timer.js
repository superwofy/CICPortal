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