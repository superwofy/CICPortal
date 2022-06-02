<?php
    $url = "";
    
    //get the image url
    if (isset( $_GET['i'] ) ) {
        $url = $_GET[ 'i' ];
    } else {
        exit();
    }

    //we can only do jpg and png here
    if (strpos($url, ".jpg") && strpos($url, ".jpeg") && strpos($url, ".png") != true ) {
        echo strpos($url, ".jpg");
        echo "Unsupported file type :(";
        exit();
    }

    //image needs to start with http
    if (substr( $url, 0, 4 ) != "http") {
        echo("Image failed :(");
        exit();
    }
ob_start("ob_gzhandler");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 2.0//EN">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <html>
 <head>
     <title>68k.news Image Viewer</title>
 </head>
 <body">
    <p style="color:white"><small><b>Viewing image:</b> <?php echo $url ?></small></p>
    <center><img src="/assets/php/image_compressed.php?i=<?php echo $url; ?>"></center>
    <br><br>
 </body>
 </html>