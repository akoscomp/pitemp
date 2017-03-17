<?php

$url = "/ramdisk/sensors.json";
$json = file_get_contents($url);
$sensors = json_decode($json, true);

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>sn</th><th>name</th><th>description</th><th>regdate</th><th>value</th><th>last_update_date</th></tr>";

$keys = array_keys($sensors);

foreach ($keys as $key) {
        echo "<tr>";
        echo "<td style='width:150px;border:1px solid black;'>" .$key. "</td>";
        echo "<td style='width:150px;border:1px solid black;'>" .$sensors[$key]["name"]. "</td>";
        echo "<td style='width:150px;border:1px solid black;'>" .$sensors[$key]["description"]. "</td>";
        echo "<td style='width:150px;border:1px solid black;'>" .$sensors[$key]["type"]. "</td>";
        echo "<td style='width:150px;border:1px solid black;'>" .number_format($sensors[$key]["value"],1). "</td>";
        echo "<td style='width:150px;border:1px solid black;'>" .$sensors[$key]["last_update_date"]. "</td>";
        echo "</tr>" . "\n";
}

echo "</table>";
?> 
