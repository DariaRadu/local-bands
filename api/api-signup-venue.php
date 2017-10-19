<?php
session_start();
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sVenueData = file_get_contents("../data/venues.txt");
$ajVenueData = json_decode($sVenueData);

$jVenue = new stdClass();
$jVenue->id = uniqid();
$jVenue->name=$_POST['venueName'];
$jVenue->address=$_POST['venueAddress'];
$jVenue->description=$_POST['venueDescription'];
$jVenue->phone=$_POST['venuePhone'];
$jVenue->email=$_POST['venueEmail'];
$jVenue->password=$_POST['venuePassword'];
$jVenue->subscribed=true;

/*$jVenue->admin="no";*/

$sFolder = '../data/venueImages/';
$picturePath = $_FILES['venueImage']['name'];
$extension = pathinfo($picturePath, PATHINFO_EXTENSION);
$VenuePictureName = md5($picturePath).'.'.$extension;
$sSaveFileTo = $sFolder.$VenuePictureName;

if ($extension=="jpg" || $extension=="png"){
    move_uploaded_file($_FILES['venueImage']['tmp_name'], $sSaveFileTo);
    $jVenue->image=$VenuePictureName;
}else{
    echo '{"signup":"error","error": "Please upload only .jpg/.png image files"}';
    exit;
}


$_SESSION['userId']=$jVenue->id;
$_SESSION['userType']='venue';

array_push($ajVenueData, $jVenue);
$sVenueData = json_encode($ajVenueData);
file_put_contents("../data/venues.txt", $sVenueData);
echo '{"signup":"success","id": "'.$_SESSION['userId'].'","userType": "'.$_SESSION['userType'].'"}';

?>

