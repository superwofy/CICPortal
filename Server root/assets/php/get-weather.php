<?php

function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_ENCODING, 0);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST , "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0");
    curl_setopt($ch, CURLOPT_REFERER, 'https://google.com/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $data = curl_exec($ch);
    $info = curl_getinfo($ch);

    if(curl_errno($ch)) {
        die("error");
    }

    curl_close($ch);

    if ($data === FALSE) {
        die("error");
    }

    return $data;
}

function request_weather() {

    libxml_use_internal_errors(true);   //avoid filling error log with malformed element warnings

    global $lat, $long, $filepath;

    $html = file_get_contents_curl("https://weather.com/weather/today/l/{$lat},{$long}?par=google&unit=m");
    $dom = new DOMDocument();
    $dom->loadHTML($html); 
    $dom->preserveWhiteSpace = false;
    $finder = new DomXPath($dom);



    /* MISC VALUES */

    $nodes = $finder->query("//*[starts-with(@class, 'SunriseSunset--dateValue--')]");
    $sunrise_time = $nodes[0]->nodeValue;
    $sunset_time = $nodes[1]->nodeValue;

    if (!$sunrise_time) {
        $fp = fopen($filepath, 'w');    //"cache" the empty data
        fclose($fp);
        die("unavailable");
    }

    $nodes = $finder->query("//*[starts-with(@class, 'InsightNotification--text--')]");
    $map_phrase = $nodes[0]->nodeValue;

    $nodes = $finder->query("//*[contains(@data-testid, 'AirQualitySeverity')]");
    $air_quality = $nodes[0]->nodeValue;




    /* TODAY FORECAST */

    $nodes = $finder->query("//*[contains(@data-testid, 'TodayWeatherModule')]");    //morning,afternoon,evening,overnight forecast panel
    $forecast_header_value =  $nodes[0]->childNodes[0]->childNodes[0]->nodeValue;            //value of the H2

    $today_breakdown_list = $nodes[0]->childNodes[1]->childNodes[0];                  //ul WeatherTable


    $today_morning_temperature = $today_breakdown_list->childNodes[0]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;                                                                                //ul-li -> a -> div -> span
    $today_morning_condition = $today_breakdown_list->childNodes[0]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue;                                            //ul-li -> a -> div -> svg -> title
    $today_morning_precipitation = $today_breakdown_list->childNodes[0]->childNodes[0]->childNodes[3]->childNodes[0]->nodeValue;                                                                              //ul-li -> a -> div -> span
    if ($today_morning_precipitation != '--') {
        $today_morning_precipitation = str_replace("Chance of Rain", '', $today_breakdown_list->childNodes[0]->childNodes[0]->childNodes[3]->childNodes[1]->nodeValue) . ' chance of rain';                   //ul-li -> a -> div -> span
    }

    $today_afternoon_temperature = $today_breakdown_list->childNodes[1]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;                          //ul-li -> a -> div -> span
    $today_afternoon_condition = $today_breakdown_list->childNodes[1]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue;             //ul-li -> a -> div -> svg -> title
    $today_afternoon_precipitation = $today_breakdown_list->childNodes[1]->childNodes[0]->childNodes[3]->childNodes[0]->nodeValue;                        //ul-li -> a -> div -> span
    if ($today_afternoon_precipitation != '--') {
        $today_afternoon_precipitation = str_replace("Chance of Rain", '', $today_breakdown_list->childNodes[1]->childNodes[0]->childNodes[3]->childNodes[1]->nodeValue) . ' chance of rain';                    //ul-li -> a -> div -> span
    }


    $today_evening_temperature = $today_breakdown_list->childNodes[2]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;                          //ul-li -> a -> div -> span
    $today_evening_condition = $today_breakdown_list->childNodes[2]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue;             //ul-li -> a -> div -> svg -> title
    $today_evening_precipitation = $today_breakdown_list->childNodes[2]->childNodes[0]->childNodes[3]->childNodes[0]->nodeValue;                        //ul-li -> a -> div -> span
    if ($today_evening_precipitation != '--') {
        $today_evening_precipitation = str_replace("Chance of Rain", '', $today_breakdown_list->childNodes[2]->childNodes[0]->childNodes[3]->childNodes[1]->nodeValue) . ' chance of rain';                    //ul-li -> a -> div -> span
    }


    $today_overnight_temperature = $today_breakdown_list->childNodes[3]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;                                                                               //ul-li -> a -> div -> span
    $today_overnight_condition = $today_breakdown_list->childNodes[3]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue;                                           //ul-li -> a -> div -> svg -> title
    $today_overnight_precipitation = $today_breakdown_list->childNodes[3]->childNodes[0]->childNodes[3]->childNodes[0]->nodeValue;                                                                             //ul-li -> a -> div -> span
    if ($today_overnight_precipitation != '--') {
        $today_overnight_precipitation = str_replace("Chance of Rain", '', $today_breakdown_list->childNodes[3]->childNodes[0]->childNodes[3]->childNodes[1]->nodeValue) . ' chance of rain';                    //ul-li -> a -> div -> span
    }



    /* HOURLY FORECAST */


    $nodes = $finder->query("//*[contains(@data-testid, 'HourlyWeatherModule')]");    //hourly forecast panel
    

    $hourly_breakdown_list = $nodes[0]->childNodes[1]->childNodes[0];                  //ul WeatherTable

    $now_temperature = $hourly_breakdown_list->childNodes[0]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;
    $now_condition = $hourly_breakdown_list->childNodes[0]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue;
    $now_precipitation = $hourly_breakdown_list->childNodes[0]->childNodes[0]->childNodes[3]->childNodes[1]->childNodes[1]->nodeValue . ' chance of rain';

    $one_hour_heading = $hourly_breakdown_list->childNodes[1]->childNodes[0]->childNodes[0]->childNodes[0]->nodeValue;
    $one_hour_temperature = $hourly_breakdown_list->childNodes[1]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;
    $one_hour_condition = $hourly_breakdown_list->childNodes[1]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue;
    $one_hour_precipitation = $hourly_breakdown_list->childNodes[1]->childNodes[0]->childNodes[3]->childNodes[1]->childNodes[1]->nodeValue . ' chance of rain';

    $two_hours_heading = $hourly_breakdown_list->childNodes[2]->childNodes[0]->childNodes[0]->childNodes[0]->nodeValue;
    $two_hours_temperature = $hourly_breakdown_list->childNodes[2]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;
    $two_hours_condition = $hourly_breakdown_list->childNodes[2]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue;
    $two_hours_precipitation = $hourly_breakdown_list->childNodes[2]->childNodes[0]->childNodes[3]->childNodes[1]->childNodes[1]->nodeValue . ' chance of rain';

    $three_hours_heading = $hourly_breakdown_list->childNodes[3]->childNodes[0]->childNodes[0]->childNodes[0]->nodeValue;
    $three_hours_temperature = $hourly_breakdown_list->childNodes[3]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;
    $three_hours_condition = $hourly_breakdown_list->childNodes[3]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue;
    $three_hours_precipitation = $hourly_breakdown_list->childNodes[3]->childNodes[0]->childNodes[3]->childNodes[1]->childNodes[1]->nodeValue . ' chance of rain';

    // $four_hours_heading = $hourly_breakdown_list->childNodes[4]->childNodes[0]->childNodes[0]->childNodes[0]->nodeValue;
    // $four_hours_temperature = $hourly_breakdown_list->childNodes[4]->childNodes[0]->childNodes[1]->childNodes[0]->nodeValue;
    // $four_hours_condition = str_replace(" ", '-', $hourly_breakdown_list->childNodes[4]->childNodes[0]->childNodes[2]->childNodes[0]->childNodes[0]->nodeValue);
    // $four_hours_precipitation = $hourly_breakdown_list->childNodes[4]->childNodes[0]->childNodes[3]->childNodes[1]->childNodes[1]->nodeValue . ' chance of rain';



    /* CACHE DATA */

    $cache = new stdClass();

    $cache->forecast_header_value = $forecast_header_value;
    $cache->today_morning_temperature = $today_morning_temperature;
    $cache->today_morning_condition = $today_morning_condition;
    $cache->today_morning_precipitation = $today_morning_precipitation;
    $cache->today_afternoon_temperature = $today_afternoon_temperature;
    $cache->today_afternoon_condition = $today_afternoon_condition;
    $cache->today_afternoon_precipitation = $today_afternoon_precipitation;
    $cache->today_evening_temperature = $today_evening_temperature;
    $cache->today_evening_condition = $today_evening_condition;
    $cache->today_evening_precipitation = $today_evening_precipitation;
    $cache->today_overnight_temperature = $today_overnight_temperature;
    $cache->today_overnight_condition = $today_overnight_condition;
    $cache->today_overnight_precipitation = $today_overnight_precipitation;

    $cache->now_temperature = $now_temperature;
    $cache->now_condition = $now_condition;
    $cache->now_precipitation = $now_precipitation;
    $cache->one_hour_heading = $one_hour_heading;
    $cache->one_hour_temperature = $one_hour_temperature;
    $cache->one_hour_condition = $one_hour_condition;
    $cache->one_hour_precipitation = $one_hour_precipitation;
    $cache->two_hours_heading = $two_hours_heading;
    $cache->two_hours_temperature = $two_hours_temperature;
    $cache->two_hours_condition = $two_hours_condition;
    $cache->two_hours_precipitation = $two_hours_precipitation;
    $cache->three_hours_heading = $three_hours_heading;
    $cache->three_hours_temperature = $three_hours_temperature;
    $cache->three_hours_condition = $three_hours_condition;
    $cache->three_hours_precipitation = $three_hours_precipitation;
    // $cache->four_hours_heading = $four_hours_heading;
    // $cache->four_hours_temperature = $four_hours_temperature;
    // $cache->four_hours_condition = $four_hours_condition;
    // $cache->four_hours_precipitation = $four_hours_precipitation;

    $cache->map_phrase = $map_phrase;
    $cache->sunrise_time = $sunrise_time;
    $cache->sunset_time = $sunset_time;
    $cache->air_quality = $air_quality;
    
    $fp = fopen($filepath, 'w');
    $written = fwrite($fp, json_encode($cache));
    fclose($fp);

    echo file_get_contents($filepath);
}


$lat = isset($_GET['lat']) ? (is_numeric($_GET['lat']) ? round(intval($_GET['lat']) / 11930464.71, 2) : "0") : "0";            //Decode compressed GPS co-ordinates.
$long = isset($_GET['long']) ? (is_numeric($_GET['long']) ? round(intval($_GET['long']) / 11930464.71, 2) : "0") : "0";

if ($lat === "0" && $long === "0") {
    die("error");
}

$VIN = isset($_GET['VIN']) ? $_GET['VIN'] : "E000000";
if (!preg_match('/[A-Z|0-9]{7}/', $VIN)) {                                                                                        //attempt to prevent directory traversal with $VIN
    exit();
}

$filepath = $_SERVER['DOCUMENT_ROOT'] . '/cache/weather/'.$VIN.'.json'; 

if (file_exists($filepath)) {
    if (time()-filemtime($filepath) < 600) {    //file newer than 10 minutes
        clearstatcache();
        if (filesize($filepath) == 0) {
            die("unavailable");
        }
        echo file_get_contents($filepath);
    } else {
        request_weather();
    }
} else {
    request_weather();
}

?>