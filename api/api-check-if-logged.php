<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();
if (!isset($_SESSION)|| $_SESSION['userId']){
    if ($_SESSION['userId']=='1'){
        echo '{"login":"admin"}';
        exit;
    }
    echo '{"login":"ok","id":"'.$_SESSION['userId'].'","userType":"'.$_SESSION['userType'].'"}';
}else{
    echo '{"login":"error"}';
}