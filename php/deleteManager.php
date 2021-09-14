<?php
if(!isset($_SESSION)){
    session_start();
}

require "./dbConnection.php";
$db = new db();

if(intval($_SESSION['userAccountLevel']) == 2 || intval($_SESSION['userID']) == intval($db->getUserIDFromPicID(intval($_POST['picID'])))){
    $db->deletePicture(intval($_POST['picID']));
}
?>
