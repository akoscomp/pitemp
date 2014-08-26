<?php
    $fileTempLog = '/home/akos/pitemp/sensors/templog.json';
    $jsonTempLog = file_get_contents($fileTempLog);
    $tempdata = json_decode($jsonTempLog, TRUE);
print_r($tempdata);    
?>


