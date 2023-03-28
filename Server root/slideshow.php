<?php
// Set ma to number of photos in /assets/img/slideshow/

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CIC Portal >> Slideshow</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
<style type="text/css">img{width:950px;height:409px}a:visited img,a:link img{border:none}</style>
</head>
<body>
<div><a href="javascript:void(0)" onclick="ss_u()"><img onload="ss_l()" onerror="ss()" id="im" class="noborder" alt=""></div></a>
<script>
function rng(){ma=624;return Math.floor(Math.random()*(ma-1)+1);}
function ss(){document.getElementById('im').src="/assets/img/slideshow/"+rng()+".jpg";}
function ss_l(){ss_t=setTimeout(ss,30000);}function ss_u(){clearTimeout(ss_t);ss();}
ss();
</script>
</body>
</html> 
