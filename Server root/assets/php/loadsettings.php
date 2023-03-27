<?php

$VIN = isset($_SERVER['HTTP_BMW_VIN']) ? $_SERVER['HTTP_BMW_VIN'] : "E000000";
if (!preg_match('/[A-Z|0-9]{7}/', $VIN)) {                                                                                       //attempt to prevent directory traversal with $VIN
    exit();
}

$filename = $_SERVER['DOCUMENT_ROOT'] . '/cache/settings/'. $VIN .'.json';
$settings = "";

if (file_exists($filename)) $settings = file_get_contents($filename);
else $settings = file_get_contents($filename);

$settings = json_decode($settings);

if (isset($_GET['development'])) {setcookie("development", 1);}

?>