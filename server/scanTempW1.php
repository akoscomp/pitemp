<?php

/* 
    A sensors mappaba kiirja a szenzorok ertekeit,
 * kinyitja, illetve bezarja a csapot, ha futeni kell
 * cron futtatja
 */

$sensorsUrl = "/home/akos/pitemp/sensors/lasttemp.json";
$jsonSensors = file_get_contents($sensorsUrl);
$sensors = json_decode($jsonSensors, TRUE);

$cacheUrl = "/home/akos/pitemp/sensors/tempcache.json";
$jsonCache = file_get_contents($cacheUrl);
$cache = json_decode($jsonCache, TRUE);

function pitemplog($text) {
//log the acction
  $current_date = date('Y-m-d - H:i:s');
  $logFile = "/home/akos/pitemp/log/pitemp.log";
  $message = $current_date." - $text\n";
  file_put_contents($logFile, $message, FILE_APPEND | LOCK_EX);
}

function switchRelay($relayid, $sensor, $mess2) {
    if ( $sensor['pinstatus'] === true ) {
	$mess = 'OFF';
        $text = 'id: '.$relayid.', '.$mess.', mess2: '.$mess2;
        pitemplog($text);
	$exec = '/home/akos/pitemp/server/relay1w.sh '.$relayid.' '.$mess;
        exec($exec);
	return $return = false;
    } else {
	$mess = 'ON';
        $text = 'id: '.$relayid.', '.$mess.', mess2: '.$mess2;
        pitemplog($text);
	$exec = '/home/akos/pitemp/server/relay1w.sh '.$relayid.' '.$mess;
        exec($exec);
	return $return = true;
    }
}

foreach ($sensors['tempsensors'] as $sensor) {
   $sensors['tempsensors'][$sensor['id']]['lastvalue'] = $cache['tempsensors'][$sensor['id']]['lastvalue'];
  
   if ( $sensor['isauto'] ) {
    if ( $sensor['type'] === "floor" ) {
            if ( $sensor['mintemp'] && $sensor['maxtemp'] ) {
	      if ($sensor['pinstatus']) {
                if ( ($sensor['maxtemp'] < $sensor['lastvalue']) ) {
                $mess2 = 'switch-off-tul-meleg';
                    $sensors['tempsensors'][$sensor['id']]['pinstatus']=switchRelay($sensor["relayid"], $sensor, $mess2);
                }
              } else {
                if ( ($sensor['mintemp'] > $sensor['lastvalue'])) {
                $mess2 = 'switch-on-tul-hideg';
                    $sensors['tempsensors'][$sensor['id']]['pinstatus']=switchRelay($sensor["relayid"], $sensor, $mess2);
                }
              }
            }
       }
   } //end isauto
} //end foreach

$out = exec('/usr/local/bin/gpio read 0');
if ( $out == 0 ) {
    $sensors['boiler']['power'] = true;
} else {
    $sensors['boiler']['power'] = false;
}

file_put_contents($sensorsUrl, json_encode($sensors, JSON_PRETTY_PRINT));
