<?php

// setcookie("VEHICLEAUTH", "", time()-3600);		//Unset old cookies
// setcookie("VINRN", "", time()-3600);
// setcookie("USERAUTH", "", time()-3600);
// setcookie("JSESSIONID", "", time()-3600);
header('Content-Type: application/xml');

if (file_exists('provision.xml')) {
	$bmwprov = simplexml_load_file('provision.xml');
	$now = new DateTime();
	$bmwprov->id = $now->format( 'Ymd-His' );	//Server time!
	echo $bmwprov->asXML();
}

?>