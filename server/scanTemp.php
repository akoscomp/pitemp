<?php

/* 
    A sensors mappaba kiirja a szenzorok ertekeit,
 * kinyitja, illetve bezarja a csapot, ha futeni kell
 * cron futtatja
 */

$sensorsUrl = "/home/akos/pitemp/sensors/lasttemp.json";
$jsonConfig = file_get_contents($sensorsUrl);
$sensors = json_decode($jsonConfig, TRUE);

$change = false;

function switchRelay($relayid) {
    $exec = '/home/akos/pitemp/server/relay.sh '.$relayid;
    exec($exec);
}

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
   if ( $sensor['isauto'] ) {
       if($sensor['type'] === "heat" ) {
            if ( !$sensor['pinstatus'] && $sensor['lastvalue'] && ($sensor['lastvalue'] < ($sensor['settemp']-$sensor['difftemp']))) {
                $sensors['tempsensors'][$sensor['id']]['pinstatus']=true;
                switchRelay($sensor["relayid"]);
            }
            if ($sensor['pinstatus'] && $sensor['lastvalue'] && ($sensor['lastvalue'] > ($sensor['settemp']+$sensor['difftemp']))) {
                $sensors['tempsensors'][$sensor['id']]['pinstatus']=false;
                switchRelay($sensor["relayid"]);
            }
       }
       if($sensor['type'] === "wall" ||  $sensor['type'] === "floor") {
            if ( $sensor['mintemp'] && $sensor['maxtemp'] ) {
                if ( ($sensor['maxtemp'] < $sensor['lastvalue']) && $sensors['tempsensors'][$sensor['id']]['pinstatus'] ) {
                    $sensors['tempsensors'][$sensor['id']]['pinstatus']=false;
                    switchRelay($sensor["relayid"]);
                }
                if ( ($sensor['mintemp'] > $sensor['lastvalue']) && !$sensors['tempsensors'][$sensor['id']]['pinstatus'] ) {
                    $sensors['tempsensors'][$sensor['id']]['pinstatus']=true;
                    switchRelay($sensor["relayid"]);
                }
            }
       }
   }
}

$out = exec('/usr/local/bin/gpio read 0');
if ( $out == 0 ) {
    $sensors['boiler']['power'] = true;
} else {
    $sensors['boiler']['power'] = false;
}

file_put_contents($sensorsUrl, json_encode($sensors, JSON_PRETTY_PRINT));
