<?php
require_once('authenticate.php');
include_once("config.php");
/* 
    A beirja a faljba a beallitott homersekletet.
 */
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$temp = filter_input(INPUT_POST, 'temp', FILTER_SANITIZE_SPECIAL_CHARS);
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);

$header = "Content-Type: application/json";
header($header);

if ( loggedIn() && inGroup('admin') ) {
    if ($type === "settemp") {
        $sensors['tempsensors'][$id]['settemp'] = floatval($temp);
    }
    if ($type === "mintemp") {
        $sensors['tempsensors'][$id]['mintemp'] = floatval($temp);
    }
    if ($type === "maxtemp") {
        $sensors['tempsensors'][$id]['maxtemp'] = floatval($temp);
    }
    if ($type === "off") {
        $sensors['tempsensors'][$id]['power'] = false;
    }
    if ($type === "on") {
        $sensors['tempsensors'][$id]['power'] = true;
    }
    $message = "Change ".$type." for sensor ".$id." to ".floatval($temp);
    pitemplog($message);
    
    file_put_contents($sensorsUrl, json_encode($sensors, JSON_PRETTY_PRINT));

    $success = true;
} else {
    $success = false;
}

print json_encode($success);
