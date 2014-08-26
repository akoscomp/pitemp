<?php

/* 
    A weblap szamara olvassa ki fajblol a homersekleteket es jsonban adja at az AJAX keresnek.
 */
$header = "Content-Type: application/json";
header($header);

include_once("config.php");


foreach ($config['tempsensors'] as $sensor) {
    //$file = $config['tempsensorsdir'].$sensor['id'].'/w1_slave';
    $file = 'sensors/'.$sensor['id'];
    if (is_readable($file) ) {
        $handle = fopen($file, "r");
        $fr = fread($handle, filesize($file));
        //print $fr;
        $fpos = strpos($fr, "t=");
        $temp =  substr($fr, $fpos+2);
        $temp =$temp/1000;
        fclose($handle);
        $tempdata[$sensor['id']] = $temp;
    } else {
        $tempdata[$sensor['id']] = 0;
    }
    
}
$tempdata = json_encode($tempdata);
print_r($tempdata);
