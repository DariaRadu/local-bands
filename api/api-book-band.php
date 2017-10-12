<?php

session_start();
$sBandData=file_get_contents("../data/bands.txt");
$ajBandData=json_decode($sBandData);
$bandId=$_GET['id'];

for ($i=0; $i<count($ajBandData);$i++){
    if ($ajBandData[$i]->id==$bandId){
        array_push($ajBandData[$i]->booking, $_POST['bandBooking']);
    }
}

$sBandData=json_encode($ajBandData);
file_put_contents("../data/bands.txt", $sBandData);
echo "yes";
