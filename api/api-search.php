<?php

session_start();
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$searchValue=$_GET['search'];

$sBandData = file_get_contents("../data/bands.txt");
$ajBandData = json_decode($sBandData);

$sVenueData = file_get_contents("../data/venues.txt");
$ajVenueData = json_decode($sVenueData);

$ajUserData=array_merge($ajBandData, $ajVenueData);
$ajResults=[];

for ($i=0;$i<count($ajUserData);$i++){
    unset($ajUserData->password);
    $notAdded=true;
    foreach ($ajUserData[$i] as $property => $value){
        if (stristr($value, $searchValue) && $notAdded==true){
            array_push($ajResults,$ajUserData[$i]);
            $notAdded=false;
        }
        /*echo "$property => $value";*/
    }
}

$sResults=json_encode($ajResults);
echo $sResults;