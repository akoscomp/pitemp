<?php

/* 
    A weblap szamara olvassa ki fajblol a homersekleteket es jsonban adja at az AJAX keresnek.
 */
$header = "Content-Type: application/json";
header($header);

$configUrl = "sensors/lasttemp.json";
$jsonConfig = file_get_contents($configUrl);
$sensors = json_decode($jsonConfig, TRUE);

foreach ($sensors['tempsensors'] as $sensor) {
        $tempdata[$sensor['id']] = $sensor['lastvalue'];
    }

$tempdata = json_encode($sensors['tempsensors']);
//$tempdata = json_encode($tempdata);
print_r($tempdata);
