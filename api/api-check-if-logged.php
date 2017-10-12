<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();
if (!isset($_SESSION)|| $_SESSION['userId']){
    echo '{"login":"ok","id":"'.$_SESSION['userId'].'","userType":"'.$_SESSION['userType'].'"}';
}else{
    echo '{"login":"error"}';
}