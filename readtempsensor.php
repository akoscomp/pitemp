<?php

/* 
    A sensors mappaba kiirja a szenzorok ertekeit, cron futtatja
 */

$sensorsUrl = "/home/akos/pitemp/sensors/lasttemp.json";
$jsonConfig = file_get_contents($sensorsUrl);
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
        $sensors['tempsensors'][$sensor['id']]['lastvalue'] = $temp;
    } else {
        $sensors['tempsensors'][$sensor['id']]['lastvalue'] = null;
    }
}
    file_put_contents($sensorsUrl, json_encode($sensors, JSON_PRETTY_PRINT));
?>
