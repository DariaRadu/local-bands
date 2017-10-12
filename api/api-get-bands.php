<?php

session_start();
$sBandData=file_get_contents("../data/bands.txt");
$ajBandData=json_decode($sBandData);
for ($i=0; $i<count($ajBandData);$i++){
    unset($ajBandData[$i]->email , $ajBandData[$i]->password, $ajBandData[$i]->songFile, $ajBandData[$i]->phone,$ajBandData[$i]->description);
}

$sBandData=json_encode($ajBandData);

echo $sBandData;