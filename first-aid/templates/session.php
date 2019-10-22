<?php  
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

if (session_status() !== 2) {
    session_start();
}

?>