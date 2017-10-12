<?php
session_start();
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sBandData = file_get_contents("../data/bands.txt");
$ajBandData = json_decode($sBandData);

$jBand = new stdClass();
$jBand->id = uniqid();
$jBand->name=$_POST['bandName'];
$jBand->genre=$_POST['bandGenre'];
$jBand->description=$_POST['bandDescription'];
$jBand->email=$_POST['bandEmail'];
$jBand->password=$_POST['bandPassword'];
$jBand->phone=$_POST['bandPhone'];
/*$jBand->admin="no";*/

$sFolder = '../data/bandImages/';
$picturePath = $_FILES['bandImage']['name'];
$extension = pathinfo($picturePath, PATHINFO_EXTENSION);
$bandPictureName = md5($picturePath).'.'.$extension;
$sSaveFileTo = $sFolder.$bandPictureName;
if ($extension=="jpg"||$extension=="png"){
    move_uploaded_file($_FILES['bandImage']['tmp_name'], $sSaveFileTo);
    $jBand->image=$bandPictureName;
}else{
    echo '{"signup":"error","error": "Please upload only .jpg/.png image files"}';
    exit;
}




$sFolderSong = '../data/bandSongs/';
$songPath = $_FILES['bandDemo']['name'];
$extensionSong = pathinfo($songPath, PATHINFO_EXTENSION);
$bandSongName = md5($songPath).'.'.$extensionSong;
$sSaveSongTo = $sFolderSong.$bandSongName;

if ($extensionSong=="mp3"){
    move_uploaded_file($_FILES['bandDemo']['tmp_name'], $sSaveSongTo);
    $jBand->songFile=$bandSongName;
}else{
    echo '{"signup":"error","error": "Please upload only .mp3 song files"}';
    exit;
}

$jBand->booking=[];

$_SESSION['userId']=$jBand->id;
$_SESSION['userType']='band';


array_push($ajBandData, $jBand);
$sBandData = json_encode($ajBandData);
file_put_contents("../data/bands.txt", $sBandData);
echo '{"signup":"success","id": "'.$_SESSION['userId'].'","userType": "'.$_SESSION['userType'].'"}';


