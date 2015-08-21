<?php

/* 
    A sensors mappaba kiirja a szenzorok ertekeit,
 * kinyitja, illetve bezarja a csapot, ha futeni kell
 * cron futtatja
 * Ez egy egyszerusitett verzio. Nem nyit csapot, csak elzarja a kazant ha kell,
 * es szinkronizalja a szenzorertekeket.
 * Cron 5 percenkent futatthatja.
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
        $exec = '/home/akos/pitemp/server/relay.sh '.$relayid.' '.$mess;
        exec($exec);
	return $return = false;
    } else {
	$mess = 'ON';
        $text = 'id: '.$relayid.', '.$mess.', mess2: '.$mess2;
        pitemplog($text);
        $exec = '/home/akos/pitemp/server/relay.sh '.$relayid.' '.$mess;
        exec($exec);
	return $return = true;
    }
}

foreach ($sensors['tempsensors'] as $sensor) {
   $sensors['tempsensors'][$sensor['id']]['lastvalue'] = $cache['tempsensors'][$sensor['id']]['lastvalue'];
} //end foreach

$out = exec('/usr/local/bin/gpio read 0');
if ( $out == 0 ) {
    $sensors['boiler']['power'] = true;
} else {
    $sensors['boiler']['power'] = false;
}

file_put_contents($sensorsUrl, json_encode($sensors, JSON_PRETTY_PRINT));
