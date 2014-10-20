<?php

/* 
    A sensors mappaba kiirja a szenzorok ertekeit,
 * kinyitja, illetve bezarja a csapot, ha futeni kell
 * cron futtatja
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
    if ( !$sensor['pinstatus'] && $sensor['lastvalue'] && ($sensor['lastvalue'] < ($sensor['settemp']-$sensor['difftemp']))) {
        exec('/usr/bin/python /home/akos/pitemp/server/relay.py');
	$sensors['tempsensors'][$sensor['id']]['pinstatus']=true;
    }
    if ($sensor['pinstatus'] && $sensor['lastvalue'] && ($sensor['lastvalue'] > ($sensor['settemp']+$sensor['difftemp']))) {
        exec('/usr/bin/python /home/akos/pitemp/server/relay.py');
	$sensors['tempsensors'][$sensor['id']]['pinstatus']=false;
    }
}
    
file_put_contents($sensorsUrl, json_encode($sensors, JSON_PRETTY_PRINT));
