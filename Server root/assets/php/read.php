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
} else {
    exit();
}

if (substr( $article_url, 0, 4 ) != "http") {
    echo("That's not a web page.";
    die();
}

$host = parse_url($article_url, PHP_URL_HOST);

use fivefilters\Readability\Readability;
use fivefilters\Readability\Configuration;
use fivefilters\Readability\ParseException;

$configuration = new Configuration();
$configuration
    ->setArticleByLine(false)
    ->setFixRelativeURLs(true)
    ->setOriginalURL('http://' . $host);

$readability = new Readability($configuration);

if(!$article_html = file_get_contents($article_url)) {
    $error_text .=  "Failed to get the article<br>";
}

try {
    $readability->parse($article_html);
    $readable_article = strip_tags($readability->getContent(), '<a><ol><ul><li><br><p><small><font><b><strong><i><em><blockquote><h1><h2><h3><h4><h5><h6>');
    $readable_article = str_replace( 'strong>', 'b>', $readable_article ); //change <strong> to <b>
    $readable_article = str_replace( 'em>', 'i>', $readable_article ); //change <em> to <i>
    
    $readable_article = clean_str($readable_article);
    $readable_article = str_replace( 'href="http', 'href="/assets/php/read.php?a=http', $readable_article ); //route links through proxy
    
} catch (ParseException $e) {
    $error_text .= 'Sorry! ' . $e->getMessage() . '<br>';
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
<title><?php echo $readability->getTitle();?></title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" rel="stylesheet">'; ?>
</head>
<body>
<hr>
<h1><?php echo clean_str($readability->getTitle());?></h1>
<p> <?php
    $img_num = 0;
    $imgline_html = "View page images:";
    foreach ($readability->getImages() as $image_url):
        //we can only do png and jpg
        if (strpos($image_url, ".jpg") || strpos($image_url, ".jpeg") || strpos($image_url, ".png") === true) {
            $img_num++;
            $imgline_html .= " <a href='/assets/php/image.php?i=" . $image_url . "'>[$img_num]</a> ";
        }
    endforeach;
    if($img_num>0) {
        echo  $imgline_html ;
    }
?></small></p>
<?php if($error_text) { echo '<p style="color:red">' . $error_text . "</p>"; } ?>
<div><?php echo $readable_article;?></div>
</body>
</html>