<?php

if(isset($_REQUEST['id']))
{
    $q = $_REQUEST["id"];

    if ($q !== "") {
      $command = "/usr/bin/gpio read $q";
      $results = exec($command);
    }

    echo $results;
}

if(isset($_REQUEST['list']))
{
    $url = "/ramdisk/gpio.json";
    $json = file_get_contents($url);
    echo $json;
}


?>

