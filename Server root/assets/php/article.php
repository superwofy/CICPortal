<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/vendor/autoload.php');

$article_url = "";
$article_html = "";
$error_text = "";

if( isset( $_GET['a'] ) ) {
    $article_url = $_GET["a"];
    if (!filter_var($article_url, FILTER_VALIDATE_URL)) {
        exit(); 
    }
    if (substr( $article_url, 0, 23 ) != "https://news.google.com") {
        echo("That's not news.");
        exit();
    }
} else {
    exit();
}

use fivefilters\Readability\Readability;
use fivefilters\Readability\Configuration;
use fivefilters\Readability\ParseException;

$configuration = new Configuration();
$configuration->setArticleByLine(false);

$readability = new Readability($configuration);


// New Javascript based google redirects when clicking RSS link. Need to extract the actual article URL
$redirection_html = file_get_contents($article_url);            
preg_match('/data-n-au=\"(.*)\"/iU', $redirection_html, $redirect_url);
$article_url = $redirect_url[1];


if(!$article_html = file_get_contents($article_url)) {
    $error_text .=  "Failed to get the article.<br>";
}

try {
    $readability->parse($article_html);
    $readable_article = strip_tags($readability->getContent(), '<ol><ul><li><br><p><small><font><b><strong><i><em><blockquote><h1><h2><h3><h4><h5><h6>');
    $readable_article = str_replace( 'strong>', 'b>', $readable_article ); //change <strong> to <b>
    $readable_article = str_replace( 'em>', 'i>', $readable_article ); //change <em> to <i>
    
    $readable_article = clean_str($readable_article);
    
} catch (ParseException $e) {
    $error_text .= $e->getMessage();
}

//replace chars that old machines probably can't handle
function clean_str($str) {
    $str = str_replace( "‘", "'", $str );    
    $str = str_replace( "’", "'", $str );  
    $str = str_replace( "“", '"', $str ); 
    $str = str_replace( "”", '"', $str );
    $str = str_replace( "–", '-', $str );
    return $str;
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>CIC Portal - Article Reader</title>
<style>p{color:white}h1{margin-bottom:20px}img{max-width:420px}</style>
<script type="text/javascript">function hi(id){document.getElementById('im'+id).style.display='none';}</script>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
</head>
<body>
<h1><?php echo clean_str($readability->getTitle());?></h1>
<p><small><?php
    $imgline_html = "";
    $img_num = 0;
    foreach ($readability->getImages() as $image_url):
        $url = strtolower($image_url);
        if (str_ends_with($url, ".jpg") || str_ends_with($url, ".jpeg") || str_ends_with($url, ".png") || str_ends_with($url, ".gif")) {
            $imgline_html .= "<a id='im" . $img_num . "' class='img' href='/assets/php/image.php?i=" . $url . "'><img onerror='hi(" . $img_num . ")' class='noborder' src='/assets/php/image_comp.php?i=" . $url . "'></img></a>";
            $img_num++;
        }
    endforeach;
    echo  $imgline_html;
?></small></p>
<?php if($error_text) { echo '<p style="color:red">' . $error_text . "</p>"; } ?>
<div><?php echo $readable_article;?></div>
</body>
</html>