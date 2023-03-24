<?php

// setcookie("VEHICLEAUTH", "", time()-3600);				//Unset old cookies
// setcookie("VINRN", "", time()-3600);
// setcookie("USERAUTH", "", time()-3600);
// setcookie("JSESSIONID", "", time()-3600);
header('Content-Type: application/xml');

$basefile = $_SERVER['DOCUMENT_ROOT'] . '/a/xml/prov.xml';
if (file_exists($basefile)) {
	$bmwprov = simplexml_load_file($basefile);
	$ota_time = new DateTime();
	$to_sub = new DateInterval('PT6H');						// Make sure OTAs are at least 6h before server time.
	$ota_time->sub($to_sub);
	$bmwprov->id = $ota_time->format( 'Ymd-His' );			// Server time!
	if (!isset($_GET['portal'])){
		echo str_replace("\n", '', $bmwprov->asXML());		// Strip line breaks
	} else {
		echo $bmwprov->asXML();
	}
}

?>