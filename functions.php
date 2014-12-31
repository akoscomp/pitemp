<?php

function loggedIn() {
	if(isset($_SESSION["authenticated"]) && ($_SESSION["authenticated"] == 'true')):
	  return true;
	else:
	  return false;
	endif;
}

function inGroup($group, $user=null) {
    global $config;
    $user= (is_null($user)) ? $_SESSION['username'] : $user;
    if(isset($group)) {
            if(in_array($user, $config['groups'][$group]))
                return true;
            else
                return false;
        }
}

function pitemplog($text) {
//log the acction
  $current_date = date('Y-m-d - H:i:s');
  $logFile = "log/pitemp.log";
    $message = $current_date." - ".$_SERVER['REMOTE_ADDR']." - $text\n";
  file_put_contents($logFile, $message, FILE_APPEND | LOCK_EX);
}

?>
