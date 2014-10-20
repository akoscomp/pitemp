<?php

/* 
    A beirja a faljba a beallitott homersekletet.
 */
$header = "Content-Type: application/json";
header($header);

$sensorsUrl = "sensors/lasttemp.json";
$jsonConfig = file_get_contents($sensorsUrl);
$sensors = json_decode($jsonConfig, TRUE);

$sensors['tempsensors'][$_POST['id']]['settemp'] = floatval($_POST['temp']);

$handle = fopen($sensorsUrl, "w");
fwrite($handle, json_encode($sensors, JSON_PRETTY_PRINT));
fclose($handle);

$success = true;

print json_encode($success);
