<?php
session_start();
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sVenueData = file_get_contents("../data/venues.txt");
$ajVenueData = json_decode($sVenueData);
$venueId=$_SESSION['userId'];

for ($i=0;$i<count($ajVenueData);$i++){
    if($ajVenueData[$i]->id==$venueId){
        $jVenue=$ajVenueData[$i];
        $jVenue->name=$_POST['venueNameEdit'];
        $jVenue->address=$_POST['venueAddressEdit'];
        $jVenue->description=$_POST['venueDescriptionEdit'];
        $jVenue->phone=$_POST['venuePhoneEdit'];
        $jVenue->email=$_POST['venueEmailEdit'];
        $jVenue->password=$_POST['venuePasswordEdit'];
        if ($_FILES['venueImageEdit']['tmp_name']){
            $sFolder = '../data/venueImages/';
            $picturePath = $_FILES['venueImageEdit']['name'];
            $extension = pathinfo($picturePath, PATHINFO_EXTENSION);
            $VenuePictureName = md5($picturePath).'.'.$extension;
            $sSaveFileTo = $sFolder.$VenuePictureName;

            if ($extension=="jpg" || $extension=="png"){
                move_uploaded_file($_FILES['venueImageEdit']['tmp_name'], $sSaveFileTo);
                $jVenue->image=$VenuePictureName;
            }else{
                echo '{"edit":"error","error": "Please upload only .jpg/.png image files"}';
                exit;
            }
        }
        $ajVenueData[$i]=$jVenue;
        $sVenueData = json_encode($ajVenueData);
        file_put_contents("../data/venues.txt", $sVenueData);
        echo '{"edit":"success","id": "'.$_SESSION['userId'].'"}';
    }
}

