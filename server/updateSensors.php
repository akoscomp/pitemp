<?php

/* 
 * Frissiti a ramdriveon a szenzorok ertekeit
 */

include_once '/home/akos/pitemp/functions.php';

$sensorDir = '/sys/bus/w1/devices/';

$url = "/ramdisk/sensors.json";
$json = file_get_contents($url);
$sensors = json_decode($json, true);

$keys = array_keys($sensors);

if (is_readable($sensorDir) ) {
    foreach ($keys as $key) {
        $file = $sensorDir.$key.'/w1_slave';
        if (is_readable($file)) {
            $handle = fopen($file, "r");
            $fr = fread($handle, filesize($file));
            $fpos = strpos($fr, "t=");
            $temp =  substr($fr, $fpos+2);
            $temp =$temp/1000;
            fclose($handle);
            if ($temp != 85) $sensors[$key]["value"] = $temp;
	    $sensors[$key]["last_update_date"] = time();
        }
    }
} else {
  pilog("Can not read sensor dir: ".$sensorDir, 0);
}

if (!is_writable($url)) {
    pilog("No write permission", 0);
} else {
  // update sensros.json with new temperatures
  pilog("Update sensors.json from w1 with new temp values", 2);
  file_put_contents($url, json_encode($sensors, JSON_PRETTY_PRINT));
}

### update gpio.json with temperaturs ###
$url = "/ramdisk/gpio.json";
$json = file_get_contents($url);
$rooms = json_decode($json, true);

foreach ($rooms as $keyRoom => $room) {
    if (isset($room["temp"])) {
	foreach ($room["temp"] as $keyType => $type) {
	  $mid = [];
	  foreach ($type["id"] as $sensorId) {
	    $mid[] = $sensors["$sensorId"]["value"];
	  }
	  $rooms["$keyRoom"]["temp"]["$keyType"]["temp"] = number_format(array_sum($mid)/count($mid),1);
	  $rooms["$keyRoom"]["temp"]["$keyType"]["updated"] = $sensors["$sensorId"]["last_update_date"];
	}
    }
}

if (!is_writable($url)) {
    pilog("No write permission", 0);
} else {
  // update gpio.json with new temperatures
  pilog("Update gpio.json from sensors.json with new temp values", 2);
  file_put_contents($url, json_encode($rooms, JSON_PRETTY_PRINT));
}
