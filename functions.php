<?php

#include_once 'config.php';

function pilog($message, $level = 1) {
  $loglevel = 3; // log level 0 - error, 1 - info, 2 - more info, 3 - debug
  $logfile = "/home/akos/pitemp/server/pitemp.log";
  if ($level === 0) {
    $message = date("Y.m.d-H:i:s")." - ERROR - ".$message."\n";
    file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);
  }
  if ($level === 1 && $loglevel >= 1) {
    $message = date("Y.m.d-H:i:s")." - info - ".$message."\n";
    file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);
  }
  if ($level === 2 && $loglevel >= 2) {
    $message = date("Y.m.d-H:i:s")." - warn - ".$message."\n";
    file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);
  }
  if ($level === 3 && $loglevel >= 3) {
    $message = date("Y.m.d-H:i:s")." - debug - ".$message."\n";
    file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);
  }
}

function gpioList() {
    $url = "/ramdisk/gpio.json";
    $json = file_get_contents($url);
    $gpio = json_decode($json, true);
    return $gpio;
}

function sensorsList() {
    $url = "/ramdisk/sensors.json";
    $json = file_get_contents($url);
    $gpio = json_decode($json, true);
    return $sensors;
}

function getTemp($roomId, $type = "air") {
  $url = "/ramdisk/gpio.json";
  $json = file_get_contents($url);
  $rooms = json_decode($json, true);
  $mid = [];

  if ($type === "air") {
      foreach ($rooms as $room) {
	if (isset($room["temp"])) {
	  $mid[] = $room["temp"]["air"]["temp"];
          if ($room["id"] == $roomId) return $room["temp"]["air"]["temp"];
	}
      }
      if ($roomId === "kazan") return number_format(array_sum($mid)/count($mid),1);
  } else {
  $url = "/ramdisk/sensors.json";
  $json = file_get_contents($url);
  $sensors = json_decode($json, true);
      foreach ($rooms as $room) {
	if (isset($room["temp"])) {
          if ($room["id"] == $roomId) $result = $room["temp"]["floor"]["temp"];
        }
      }
    //type=floor
    return 0;
  }
}

function getNewGroup($groups, $last) {
  $keys = array_keys($groups);
  foreach($keys as $key => $value) {
    if ($value == $last) {
      return ($key == count($keys)-1) ? $keys[0] : $keys[$key+1];
    }
  }
}

function heatStart($keys) {
  pilog("Bekapcsol a futes itt: ".implode(",", $keys), 3);

  $dataDir="/ramdisk";
  $url = "$dataDir/gpio.json";
  $json = file_get_contents($url);
  $gpio = json_decode($json, true);
  if (count($keys) > 0) {
    foreach ($keys as $key) $gpio[$key]["value"]=0;
    $gpio[0]["value"]=0;
  }
}

function heatStop($keys) {
  pilog("Mindenhol kikapcsol a futes: ".implode(",", $keys), 2);
  foreach ($keys as $key) exec("/usr/bin/gpio write $key 1");
}

