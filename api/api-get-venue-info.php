<?php

$sVenueData=file_get_contents("../data/venues.txt");
$ajVenueData=json_decode($sVenueData);
$venueId=$_GET['id'];

for ($i=0;$i<count($ajVenueData);$i++){
    if ($ajVenueData[$i]->id==$venueId){
        $jVenue=$ajVenueData[$i];
        $sVenue=json_encode($jVenue);
        echo $sVenue;
    }
}