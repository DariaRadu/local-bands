<?php
session_start();
$sBandData=file_get_contents("../data/bands.txt");
$ajBandData=json_decode($sBandData);
$bandId=$_GET['id'];

for ($i=0;$i<count($ajBandData);$i++){
    if ($bandId==$ajBandData[$i]->id){
        $jBand=$ajBandData[$i];
        $jBand->name=$_POST['bandNameEdit'];
        $jBand->genre=$_POST['bandGenreEdit'];
        $jBand->description=$_POST['bandDescriptionEdit'];
        $jBand->email=$_POST['bandEmailEdit'];
        $jBand->password=$_POST['bandPasswordEdit'];
        $jBand->phone=$_POST['bandPhoneEdit'];

        if ($_FILES['bandImageEdit']['tmp_name']){
            $sFolder = '../data/bandImages/';
            $picturePath = $_FILES['bandImageEdit']['name'];
            $extension = pathinfo($picturePath, PATHINFO_EXTENSION);
            $bandPictureName = md5($picturePath).'.'.$extension;
            $sSaveFileTo = $sFolder.$bandPictureName;
            if ($extension=="jpg"||$extension=="png"){
                move_uploaded_file($_FILES['bandImageEdit']['tmp_name'], $sSaveFileTo);
                $jBand->image=$bandPictureName;
            }else{
                echo '{"edit":"error","error": "Please upload only .jpg/.png image files"}';
                exit;
            }
        }

        if ($_FILES['bandDemoEdit']['tmp_name']){
            $sFolderSong = '../data/bandSongs/';
            $songPath = $_FILES['bandDemoEdit']['name'];
            $extensionSong = pathinfo($songPath, PATHINFO_EXTENSION);
            $bandSongName = md5($songPath).'.'.$extensionSong;
            $sSaveSongTo = $sFolderSong.$bandSongName;

            if ($extensionSong=="mp3"){
                move_uploaded_file($_FILES['bandDemoEdit']['tmp_name'], $sSaveSongTo);
                $jBand->songFile=$bandSongName;
            }else{
                echo '{"edit":"error","error": "Please upload only .mp3 song files"}';
                exit;
            }
        }

        $ajBandData[$i]=$jBand;
        $sBandData=json_encode($ajBandData);
        file_put_contents("../data/bands.txt", $sBandData);
        echo '{"edit":"success","id": "'.$jBand->id.'"}';
        exit;
    }
}