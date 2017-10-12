<?php
session_start();

$sBandData = file_get_contents("../data/bands.txt");
$ajBandData = json_decode($sBandData);

$sVenueData = file_get_contents("../data/venues.txt");
$ajVenueData = json_decode($sVenueData);

$ajUserData=array_merge($ajBandData, $ajVenueData);

$userId=$_GET['id'];

for ($i=0;$i<count($ajUserData);$i++){
    if ($ajUserData[$i]->id==$userId){
        $jUser=$ajUserData[$i];
        $sUser=json_encode($jUser);
        echo $sUser;
    }
}