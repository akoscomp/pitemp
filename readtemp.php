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
$logdate = $date[0]*1000;


$arr = array(array('v' => 'Date('.$logdate.')'));
foreach ($sensors['tempsensors'] as $sensor) {
    $arr[] = array('v' => $sensor['lastvalue']);
}
//print_r($arr);
$tempdata['rows'][]=array('c' => $arr);
//print_r($tempdata);


$handle = fopen($fileTempLog, "w");
fwrite($handle, json_encode($tempdata, JSON_PRETTY_PRINT));
fclose($handle);

?>
