<?php

/* 
    Ez generelja le a grafikonnak a templog.json-t
    cron kell futtassa
 */

$sensorsUrl = "/home/akos/pitemp/sensors/lasttemp.json";
$jsonConfig = file_get_contents($sensorsUrl);
$sensors = json_decode($jsonConfig, TRUE);

$fileTempLog = '/home/akos/pitemp/sensors/templog.json';
$jsonTempLog = file_get_contents($fileTempLog);
$tempdata = json_decode($jsonTempLog, TRUE);

$date = getdate();
$logdate = $date[0];

print_r($tempdata);

foreach ($sensors['tempsensors'] as $sensor) {
    $file = $sensors['tempsensorsdir'].$sensor['id'].'/w1_slave';
    $fileout = '/home/akos/pitemp/sensors/'.$sensor['id'];
    if (is_readable($file) ) {
        exec('cat '.$file.' > '.$fileout);
    }
    if (is_readable($fileout) ) {
        $handle = fopen($fileout, "r");
        $fr = fread($handle, filesize($fileout));
        $fpos = strpos($fr, "t=");
        $temp = substr($fr, $fpos+2);
        $temp = $temp/1000;
        fclose($handle);
        /*
        if (array_key_exists($logdate, $tempdata['rows'][$sensor['id']])) {
            $tempdata['rows'][$sensor['id']][$logdate] = ($tempdata['rows'][$sensor['id']][$logdate] + $temp)/2;
        } else {
            $tempdata['rows'][$sensor['id']][$logdate] = $temp;
        }*/
    }
    $temps[$sensor['id']] = $temp;
}
//sensors order: 28-00042c641cff | 28-00042d40e2ff | 28-00042c66a9ff
$command = '/usr/bin/rrdtool update /home/akos/pitemp/graphs/tempmind.rrd N:'.$temps['28-00042c641cff'].':'.$temps['28-00042d40e2ff'].':'.$temps['28-00042c66a9ff'];
//echo $command."\n";
//exec($command);

/*
$handle = fopen($fileTempLog, "w");
fwrite($handle, json_encode($tempdata, JSON_PRETTY_PRINT));
fclose($handle);
*/
/*
 RRDtool create database:
 rrdtool create tempmind.rrd \
 --step 300 \
 DS:28-00042c641cff:GAUGE:600:-50:100 \
 DS:28-00042d40e2ff:GAUGE:600:-50:100 \
 DS:28-00042c66a9ff:GAUGE:600:-50:100 \
 RRA:AVERAGE:0.1:1:2016
 */

?>
