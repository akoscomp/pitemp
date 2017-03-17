<?php
/* 
 * Frissiti a GPIO ertekeit, cron kell futtassa 1 percenkent
 */

#include_once '/home/akos/pitemp/functions.php';

$url = "/ramdisk/gpio.json";
$json = file_get_contents($url);
$gpio = json_decode($json, true);

$keys = array_keys($gpio);
$res0="";
$res="";

foreach ($gpio as $key => $value) {
  $res0 = $res0.$value["value"];
}

foreach ($keys as $key) {
  $command = '/usr/bin/gpio read '.$key;
  $res = $res.exec($command);
}

print "file: ".$res0."\n";
print "gpio: ".$res."\n";
#pilog("gpio: ".$res, 3);

