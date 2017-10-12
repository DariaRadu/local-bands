<?php
session_start();
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$sBandData = file_get_contents("../data/bands.txt");
$ajBandData = json_decode($sBandData);

$sVenueData = file_get_contents("../data/venues.txt");
$ajVenueData = json_decode($sVenueData);

$ajUserData=array_merge($ajBandData, $ajVenueData);

// Data comes from the browser
$sUserEmail = $_POST['loginEmail'];
$sUserPassword = $_POST['loginPassword'];

for ($i=0;$i<count($ajUserData);$i++){
    $sCorrectEmail = $ajUserData[$i]->email;
    $sCorrectPassword = $ajUserData[$i]->password;
    if ($sUserEmail==$sCorrectEmail && $sUserPassword==$sCorrectPassword){
        $userId =$ajUserData[$i]->id;
        $_SESSION['userId']=$userId;
        if($ajUserData[$i]->genre){
            $_SESSION['userType']='band';
        }else{
            $_SESSION['userType']='venue';
        }
        echo '{"login":"ok","id":"'.$userId.'","userType":"'.$_SESSION['userType'].'"}';
        exit;
    };
};

echo '{"login":"error"}';