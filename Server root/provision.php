<?php

// setcookie("VEHICLEAUTH", "", time()-3600);				//Unset old cookies
// setcookie("VINRN", "", time()-3600);
// setcookie("USERAUTH", "", time()-3600);
// setcookie("JSESSIONID", "", time()-3600);
header('Content-Type: application/xml');

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/a/xml/prov.xml')) {
	$bmwprov = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/a/xml/prov.xml');
	$ota_time = new DateTime();
	$to_sub = new DateInterval('PT6H');						// Make sure OTAs are at least 6h before server time.
	$ota_time->sub($to_sub);
	$bmwprov->id = $ota_time->format( 'Ymd-His' );			// Server time!
	echo $bmwprov->asXML();
	//echo str_replace("\n", '', $bmwprov->asXML());			// Strip line breaks
}

?>