<?php

$sVenuesData=file_get_contents("../data/venues.txt");
$ajVenuesData=json_decode($sVenuesData);

for($i=0;$i<count($ajVenuesData);$i++){
    unset($ajVenuesData[$i]->email, $ajVenuesData[$i]->password, $ajVenuesData[$i]->description, $ajVenuesData[$i]->phone);
}

$sVenuesData=json_encode($ajVenuesData);

echo $sVenuesData;