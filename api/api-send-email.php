<?php
ini_set("SMTP","ssl://smtp.gmail.com");
ini_set("smtp_port","465");
$headers = 'From: Local Bands <no-reply@localbands.com>';
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$sVenueData=file_get_contents("../data/venues.txt");
$ajVenueData=json_decode($sVenueData);

/*$sBandData=file_get_contents('../data/bands.txt');
$ajBandData=json_decode($sBandData);
$bandId=$_GET['id'];

for ($i=0;$i<count($ajBandData);$i++){
    if($ajBandData[$i]->id==$bandId){
        $jBand=$ajBandData[$i];
    }
}*/

$content='<html>
    <head>
        <style>
            *{
                font-family:Arial, sans-serif;
                text-align:center;
            }
            p{
                color:gray;
            }
            a{
                text-decoration:none;
                color:white;
            }
            button{
                background-color:orange;
                border:none;
                padding:5px 10px;
            }
        </style>
    </head>
    <body>
    <h2>A new band has joined our community!</h2>
    <p>Someone new has joined LocalBands. Check Them Out!</p>
    <button><a href="ohdaria.com/localBands">Go to website</a></button>
    </body>
</html>';

for ($i=0;$i<count($ajVenueData);$i++){
    if ($ajVenueData[$i]->subscribed=="true"){
        mail ( "dariaradur3@gmail.com" , "A New Band has joined the community!" , $content, $headers);
    }
}

echo "mail";