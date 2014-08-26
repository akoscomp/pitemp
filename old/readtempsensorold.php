<?php

/* 
    A sensors mappaba kiirja a szenzorok ertekeit, cron futtatja
 */

$configUrl = "/home/akos/pitemp/data/config.json";
$jsonConfig = file_get_contents($configUrl);
$config = json_decode($jsonConfig, TRUE);

foreach ($config['tempsensors'] as $sensor) {
    $file = $config['tempsensorsdir'].$sensor['id'].'/w1_slave';
    $fileout = '/home/akos/pitemp/sensors/'.$sensor['id'];
    if (is_readable($file) ) {
        exec('cat '.$file.' > '.$fileout);
    }
}
?>
