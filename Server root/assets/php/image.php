<?php
$url = "";

//get the image url
if (isset( $_GET['i'] ) ) {
    $url = $_GET[ 'i' ];
} else {
    exit();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');    
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
<title>CIC Portal - Web Image Viewer</title>
</head>
<body>
<p style="color:white;text-align:center;font-size:24px"><b>Viewing image:</b> <?php echo basename($url) ?></p>
<center><img src="/assets/php/image_comp.php?i=<?php echo $url; ?>"></center>
<br><br>
</body>
</html>