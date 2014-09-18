<?php

/* 
 * Ez törli ki a templog.json-ból a nem szükséges adatokat.
 * Cron futtatja.
 */

function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

$fileTempLog = '/home/akos/pitemp/sensors/templog.json';
$jsonTempLog = file_get_contents($fileTempLog);
$tempdata = json_decode($jsonTempLog, TRUE);

$date = getdate();
$logdate = $date[0]*1000;

$fourh = 14400;
$sixh = 21600;
$day = 86400;
$week = 604800;
$month = 18144000;
$precision = $fourh;
$showtime = $date[0] - $week;

foreach ($tempdata['rows'] as $key => $row) {
        $logtime = intval(substr($row['c'][0]['v'], 5, 10));
        $dayid = (int) ($logtime / $precision);
        $dayid *= $precision;
        $string = "Date(".$dayid."000)";
        if ( $logtime < $showtime) {
            $searchKey = recursive_array_search($string, $tempdata['rows']);
            if ($searchKey !== false) {
                if ($string != $tempdata['rows'][$key]['c'][0]['v']) {
                    unset($tempdata['rows'][$key]);
                }
            }
            else {
                $tempdata['rows'][$key]['c'][0]['v'] = $string;
            }
        }
}

$tempdata['rows'] = array_values($tempdata['rows']);

$fileOut = '/home/akos/pitemp/sensors/templog.json';
$handle = fopen($fileOut, "w");
fwrite($handle, json_encode($tempdata));
fclose($handle);

/*
 * I try to store the avg values, but I can't finish this part
 
foreach ($tempdata['rows'] as $key => $row) {
        $logtime = intval(substr($row['c'][0]['v'], 5, 10));
        $dayid = (int) ($logtime / $day);
        $dayid *= $day;
        $string = "Date(".$dayid."000)";
        if ( $logtime < $showtime) {
            $searchKey = recursive_array_search($string, $tempdata['rows']);
                //echo 'key: '.$searchKey.'</br>';
            if ($searchKey !== false) {
                foreach ($tempdata['rows'][$key]['c'] as $avgkey => $avgrow) {
                    $avg[$string][$avgkey][] = $avgrow['v'];
                }
                unset($tempdata['rows'][$key]);
                //echo 'unset: '.$key.'</br>';
            }
            else {
                $tempdata['rows'][$key]['c'][0]['v'] = $string;
                //echo 'found: '.$string.'</br>';
                foreach ($tempdata['rows'][$key]['c'] as $avgkey => $avgrow) {
                    $avg[$string][$avgkey][] = $avgrow['v'];
                }
                //echo '</br>key: '.$key.'</br>';
                //print_r($avg);
            }
        } else {
            unset($tempdata['rows'][$key]);
        }
}

foreach ($avg as $key => $row) {
    $values = count($row[0]);
    $sennum = count($row);
    echo '</br>row:'.$values.', sennum: '.$sennum.'</br>';
    print_r($row);
    echo '</br>date:'.$row[0][0].'</br>';
    for ($i = 1; $i <= $sennum; $i++) {
        for ($j = 0; $j < $values; $i++) {
            $vals[$row[0][0]][$i] += $row[$sennum][$values];
        }
    }
    echo '</br></br></br>Vals:</br>';
    print_r($vals);
//        $results[$row[0][0]] = 
}
*/

?>
