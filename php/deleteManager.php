<?php
if(!isset($_SESSION)){
    session_start();
}

require "../php/dbConnection.php";

$db = new db();

if(intval($_SESSION['userAccountLevel']) == 2 || intval($_SESSION['userID']) == intval($db->getUserIDFromPicID(intval($_POST['picID'])))){
    require "./dbConnection.php";
    $db = new db();
    $db->deletePicture(intval($_POST['picID']));
}
?>
