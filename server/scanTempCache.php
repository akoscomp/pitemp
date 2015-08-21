<?php

/* 
    A sensors mappaba kiirja a szenzorok ertekeit,
 * kinyitja, illetve bezarja a csapot, ha futeni kell
 * cron futtatja
 */

$cacheUrl = "/home/akos/pitemp/sensors/tempcache.json";
$jsonConfig = file_get_contents($cacheUrl);
$sensors = json_decode($jsonConfig, TRUE);

foreach ($sensors['tempsensors'] as $sensor) {
    $file = '/sys/bus/w1/devices/'.$sensor['id'].'/w1_slave';
    if (is_readable($file) ) {
        $handle = fopen($file, "r");
        $fr = fread($handle, filesize($file));
        $fpos = strpos($fr, "t=");
        $temp =  substr($fr, $fpos+2);
        $temp =$temp/1000;
        fclose($handle);
	if ($temp == 85) {
    	    $sensors['tempsensors'][$sensor['id']]['lastvalue'] = null;
	} else {
    	    $sensors['tempsensors'][$sensor['id']]['lastvalue'] = $temp;
	}
    } else {
        $sensors['tempsensors'][$sensor['id']]['lastvalue'] = null;
    }
} //end foreach

file_put_contents($cacheUrl, json_encode($sensors, JSON_PRETTY_PRINT));
