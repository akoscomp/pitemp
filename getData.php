<?php 
/*
 * 1 nap 86400 mp
 * 
$header = "Content-Type: application/json";
header($header);
*/

$date = getdate();
$showtime = $date[0] - 86400;
        
if (isset($_GET['day'])) {
    $showtime = $date[0] - ($_GET['day'] * 86400);
}

$fileTempLog = "sensors/templog.json";
$jsonTempLog = file_get_contents($fileTempLog);
$tempdata = json_decode($jsonTempLog, TRUE);


foreach ($tempdata['rows'] as $key => $row) {
        $logtime = intval(substr($row['c'][0]['v'], 5, 10));
        if ( $logtime < $showtime) {
            unset($tempdata['rows'][$key]);
            //echo $key.'</br>';
        }
}

$tempdata['rows'] = array_values($tempdata['rows']);

echo json_encode($tempdata);

?>