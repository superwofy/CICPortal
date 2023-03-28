<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/autoloader.php');

$section="";
if(isset( $_GET['section'])) {
	if (in_array($_GET['section'], array("top", "world", "nation", "business", "technology", "entertainment", "sports", "science", "health"))) {
		$section = $_GET["section"];
	} else {
		$section="";
	}
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/loadsettings.php');
$loc = $settings->country;
$lang = $settings->language;

$feed_url="";
if($section) {
	$feed_url="https://news.google.com/news/rss/headlines/section/topic/".strtoupper($section)."?ned=".$loc."&hl=".$lang;
} else {
	$feed_url="https://news.google.com/rss?gl=".$loc."&hl=".$lang."-".$loc."&ceid=".$loc.":".$lang;
}

//https://news.google.com/news/rss/headlines/section/topic/CATEGORYNAME?ned=in&hl=en
$feed = new SimplePie();
 
// Set the feed to process.
$feed->set_feed_url($feed_url);


// Set cache location
$feed->set_cache_location($_SERVER['DOCUMENT_ROOT'] . '/cache/news');

 
// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();

//replace chars that old machines probably can't handle
function clean_str($str) {
    $str = str_replace( "‘", "'", $str );    
    $str = str_replace( "’", "'", $str );  
    $str = str_replace( "“", '"', $str ); 
    $str = str_replace( "”", '"', $str );
    $str = str_replace( "–", '-', $str );
	$str = str_replace( '&nbsp;', ' - ', $str );

    return $str;
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/minify.php');
ob_start("minifier");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">#k68<?php if($section){echo ',.'.$section;}?>{color:#9400d3}</style>

<title>CIC Portal > 68k.news</title>
<?php if (isset($_COOKIE['development'])) echo '<link href="/assets/css/default_bon.css" type="text/css" rel="stylesheet">'; ?>
</head>
<body>
	<center><h1><b>68k.news:</b><span id="k68"><i> Headlines from the Future </i></span><?php echo strtoupper($loc) ?></h1></center>
	<small>
	<p>
	<center><a href="/news.php">TOP</a> <a class="world" href="/news.php?section=world">WORLD</a> <a class="nation" href="/news.php?section=nation">NATION</a> <a class="business" href="/news.php?section=business">BUSINESS</a> <a class="technology" href="/news.php?section=technology">TECHNOLOGY</a> <a class="entertainment" href="/news.php?section=entertainment">ENTERTAINMENT</a> <a class="sports" href="/news.php?section=sports">SPORTS</a> <a class="science" href="/news.php?section=science">SCIENCE</a> <a class="health" href="/news.php?section=health">HEALTH</a><br>
	<hr>
	</center>
	</p>
	</small>
	<?php
	if($section) {
		$section_title = explode(" - ", strtoupper($feed->get_title()));
		echo "<center><h2>" . $section_title[0]  . "</h2></center>";
	}
	/*
	Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
	*/
	foreach ($feed->get_items() as $item):
	?>
			<p><?php 
            $subheadlines = clean_str($item->get_description());
            $remove_google_link = explode("<li><strong>", $subheadlines);
            $no_blank = str_replace('target="_blank"', "", $remove_google_link[0]) . "</li></ol></p>"; 
            $cleaned_links = str_replace('<a href="', '<a href="/assets/php/article.php?a=', $no_blank);
			$cleaned_links = strip_tags($cleaned_links, '<a><ol><ul><li><br><p><small><font><b><strong><i><em><blockquote><h1><h2><h3><h4><h5><h6>');
    		$cleaned_links = str_replace( 'strong>', 'b>', $cleaned_links); //change <strong> to <b>
    		$cleaned_links = str_replace( 'em>', 'i>', $cleaned_links); //change <em> to <i>
			$cleaned_links = str_replace( "View Full Coverage on Google News", "", $cleaned_links);
            echo $cleaned_links;
            ?></p>
			<p><small>Posted on <?php echo $item->get_date('j F Y \a\t g:i a'); ?></small></p>
			<hr>
	<?php endforeach; ?>
</body>
</html>