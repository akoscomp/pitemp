<?php

/*
 * Vezerli a futest, cron futtatja percenkent
 */

include_once('/home/akos/pitemp/functions.php');

$dataDir="/ramdisk";
$urlGpio = "$dataDir/gpio.json";
$json = file_get_contents($urlGpio);
$gpio = json_decode($json, true);

$urlSettings = "$dataDir/settings.json";
$json = file_get_contents($urlSettings);
$settings = json_decode($json, true);

$ht=$settings["heatTime"]*60;
$hs=$settings["heatStart"];
$hp=$settings["heatPause"]*60;
$dt=$settings["dayTemp"];
$nt=$settings["nightTemp"];
$lg=$settings["lastGroup"];
$rt=$dt;
$time=time();
$hour=time("H");
$heat = [];
$changes=false;

if ($hour < 6 and $hour > 20) $rt = $nt;

pilog("Inne fut:  ".$hs.", celtemp: ".$rt, 3);
pilog("Ido:       ".$time, 3);
pilog("Eddig fut: ".($hs+$ht).", meg: ".($hs+$ht-$time)." s", 3);
pilog("Szunettel: ".($hs+$ht+$hp).", meg: ".($hs+$ht+$hp-$time)." s", 3);

# fut a rendszer nem kell semmit csinalni
if (($time > $hs) && ($time < $hs+$ht)) {
  pilog("Meg fut a rendszer, ".$lg.". csoport ".($hs+$ht-$time)." s", 3);
  } else {

  # lejart a futesi ido es a futesi szunet is, tehat ujra kell futani uj csoportot
  if ($hs+$ht+$hp < $time) {
    pilog("Most futeni kell", 3);
    $settings["heatStart"] = $time;
    $newGroup = getNewGroup($settings["heatGroups"],$settings["lastGroup"]);
    $settings["lastGroup"] = $newGroup;
    foreach ($gpio as $key => $room){
      if ( in_array($room["id"], $settings["heatGroups"][$newGroup]) ) {
        if ($room["temp"]["air"]["temp"] < $rt) {
          $gpio[$key]["value"]=0;
          pilog("Bekapcsolt: ".$key,3);
          $gpio[0]["value"]=0;
        }
      }
    }
    pilog("Bekapcsolt a futes GPIO[0]=".$gpio[0]["value"].", meg fut, ".$lg.". csoport: ".($ht)." s", 2);
    $changes=true;
  } else { # ha meg futesi szunet van, akkor le kell zarni a foutest

    if ( $gpio[0]["value"] == 0 ) {
      pilog("Stop heating",2);
      foreach($gpio as $key => $value) {
        $gpio[$key]["value"]=1;
        $changes=true;
      }
    } else {
      pilog("Mar le van zarva a futes: GPIO[0]=".$gpio[0]["value"], 3);
    }
  }
}

if ( !is_writable($urlGpio) || !is_writable($urlSettings) ) {
    pilog("No write permission", 0);
} else {
  // update gpio.json with new temperatures and settings.json with new settings
  if ($changes) {
    pilog("Update gpio.json with new GPIO values and/or settings.json", 2);
    file_put_contents($urlGpio, json_encode($gpio, JSON_PRETTY_PRINT));
    file_put_contents($urlSettings, json_encode($settings, JSON_PRETTY_PRINT));
  }
}
