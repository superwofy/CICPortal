<?php

// setcookie("VEHICLEAUTH", "", time()-3600);				//Unset old cookies
// setcookie("VINRN", "", time()-3600);
// setcookie("USERAUTH", "", time()-3600);
// setcookie("JSESSIONID", "", time()-3600);
header('Content-Type: application/xml');
ob_start("ob_gzhandler");

if (file_exists('provision.xml')) {
	$bmwprov = simplexml_load_file('provision.xml');
	$ota_time = new DateTime();
	$to_sub = new DateInterval('PT12H');					// Make sure OTAs are at least 12h before server time.
	$ota_time->sub($to_sub);
	$bmwprov->id = $ota_time->format( 'Ymd-His' );			// Server time!
	echo str_replace("\n", '', $bmwprov->asXML());			// Strip line breaks
}

?>