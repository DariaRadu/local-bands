<?php

$sBandData=file_get_contents('../data/bands.txt');
$ajBandData=json_decode($sBandData);
$bandId=$_GET['id'];

for ($i=0;$i<count($ajBandData);$i++){
    if($ajBandData[$i]->id==$bandId){
        $jBand=$ajBandData[$i];
        unset($jBand->password);
        $sBand=json_encode($jBand);
        echo $sBand;
    }
}
