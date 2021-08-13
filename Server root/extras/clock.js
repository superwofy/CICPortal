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