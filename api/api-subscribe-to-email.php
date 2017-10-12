<?php
session_start();
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sVenueData = file_get_contents("../data/venues.txt");
$ajVenueData = json_decode($sVenueData);
$venueId=$_SESSION['userId'];

for ($i=0;$i<count($ajVenueData);$i++){
    if ($ajVenueData[$i]->id==$venueId){
        $ajVenueData[$i]->subscribed=='true'?  $ajVenueData[$i]->subscribed='false':  $ajVenueData[$i]->subscribed='true';
        echo  $ajVenueData[$i]->subscribed;
        $sVenueData=json_encode($ajVenueData);
        file_put_contents("../data/venues.txt", $sVenueData);

        exit;
    }
}
echo $venueId;
