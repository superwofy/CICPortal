var data=[{city:"SAN FRANCISCO",tz:-7,},{city:"NEW YORK",tz:-4,},{city:"LONDON",tz:1},{city:"PARIS",tz:2},{city:"MOSCOW",tz:3},{city:"TOKYO",tz:9},{city:"SYDNEY",tz:10}];
var t=document.getElementById('t');
var u_tz=parseInt((document.getElementById('u_tz')).innerHTML,10);
function f(){
t.innerHTML='';
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
if(i%2==0){rowclass="dark";}
tr.innerHTML='<div><div class="'+rowclass+' col"><h3>'+data[i].city+'</h3><p>'+day+' '+month+' '+year+'</p></div><div class="'+rowclass+' col col2">'+time+'</div></div>';
t.appendChild(tr);
}}
f();
setInterval(f,10000);