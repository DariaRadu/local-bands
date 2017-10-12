<?php
session_start();

$sVenueData = file_get_contents("../data/venues.txt");
$ajVenueData = json_decode($sVenueData);

$userId=$_SESSION['userId'];

for ($i=0;$i<count($ajVenueData);$i++){
    if ($ajVenueData[$i]->id==$userId){
        array_splice($ajVenueData,$i,1);
        $sVenueData=json_encode($ajVenueData);
        file_put_contents("../data/venues.txt",$sVenueData);
        $_SESSION['userId']=false;
        session_destroy();
        echo "deleted";
    }
}