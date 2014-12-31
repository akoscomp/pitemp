<?php

/* 
    Ez generelja le a grafikonnak a templog.json-t
    cron kell futtassa
 */

$sensorsUrl = "/home/akos/pitemp/sensors/templog.json";
$jsonConfig = file_get_contents($sensorsUrl);
$sensors = json_decode($jsonConfig, TRUE);



$handle = fopen($sensorsUrl, "w");
fwrite($handle, json_encode($sensors, JSON_PRETTY_PRINT));
fclose($handle);

?>
