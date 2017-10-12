<?php
session_start();

$sBandData = file_get_contents("../data/bands.txt");
$ajBandData = json_decode($sBandData);

$userId=$_SESSION['userId'];

for ($i=0;$i<count($ajBandData);$i++){
    if ($ajBandData[$i]->id==$userId){
        array_splice($ajBandData,$i,1);
        $sBandData=json_encode($ajBandData);
        file_put_contents("../data/bands.txt",$sBandData);
        $_SESSION['userId']=false;
        session_destroy();
        echo "deleted";
        exit;
    }
}
