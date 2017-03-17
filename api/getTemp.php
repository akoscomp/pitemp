<?php

if(isset($_REQUEST['id']))
{
    $q = $_REQUEST["id"];

    if ($q !== "") {
      $url = "/ramdisk/sensors.json";
      $json = file_get_contents($url);
      $sensors = json_decode($json, true);
      foreach ($sensors as $sensor) {
	if ($sensor["name"] == $q) echo json_encode(number_format($sensor["value"],1));
      }
    }
}

if(isset($_REQUEST['list']))
{
    $url = "/ramdisk/sensors.json";
    $json = file_get_contents($url);
    echo $json;
}

?>
