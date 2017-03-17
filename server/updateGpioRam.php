<?php
/* 
 * Frissiti a GPIO ertekeit, cron kell futtassa 1 percenkent
 */

include_once '/home/akos/pitemp/functions.php';

$url = "/ramdisk/gpio.json";
$json = file_get_contents($url);
$gpio = json_decode($json, true);
$changes = false; //monitor the changes
$gpioValueList = "";

$keys = array_keys($gpio);

foreach ($keys as $key) {
  $command = '/usr/bin/gpio read '.$key;
  $gpioValue = exec($command);
  $gpioValueList = $gpioValueList.$gpio[$key]["value"];
  if (($gpioValue != $gpio[$key]["value"]) && (($key != 0) || ($gpioValue == 0))) {
    $command = '/usr/bin/gpio write'." ".$key." ".$gpio[$key]["value"];
    $results = exec($command);
    (!$results) ? pilog("GPIO ".$key." changed from ".$gpioValue." to ".$gpio[$key]["value"],3) : pilog("Error in updateGpio write",0);
    $changes = true;
  }
}

if ($changes) {
  pilog("GPIO updated with new GPIO values: ".$gpioValueList, 2);
} else {
  pilog("Unchanged GPIO values", 3);
  $command = '/usr/bin/gpio read 0';
  $gpioValue = exec($command);
  if ($gpioValue != $gpio[0]["value"]) {
    $command = '/usr/bin/gpio write'." 0 ".$gpio[0]["value"];
    $results = exec($command);
    (!$results) ? pilog("GPIO 0 changed from ".$gpioValue." to ".$gpio[$key]["value"],3) : pilog("Error in updateGpio write",0);
  }
}

?>
