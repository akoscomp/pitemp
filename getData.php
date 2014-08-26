<?php 
/*
$header = "Content-Type: application/json";
header($header);
*/
$string = file_get_contents("sensors/templog.json");
echo $string;

?>