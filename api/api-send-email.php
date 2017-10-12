<?php
ini_set("SMTP","ssl://smtp.gmail.com");
ini_set("smtp_port","465");
$headers = 'From: Birthday Reminder <birthday@example.com>';

$sVenueData=file_get_contents("../data/venues.txt");
$ajVenueData=json_decode($sVenueData);

for ($i=0;$i<count($ajVenueData);$i++){
    if ($ajVenueData[$i]->subscribed=="true"){
        mail ( "dariaradur3@gmail.com" , "something" , "hi", $headers);
    }
}

echo "mail";