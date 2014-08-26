<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ob_start();
date_default_timezone_set('Europe/Bucharest');

$configUrl = "data/config.json";
$jsonConfig = file_get_contents($configUrl);
$config = json_decode($jsonConfig, TRUE);

//include("functions.php");

//if ($config['debug']) error_reporting(E_ALL);

?>
