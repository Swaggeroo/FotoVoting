<?php
if(!isset($_SESSION)){
    session_start();
}
require "./dbConnection.php";
$db = new db();
if (!$db->hasLiked(intval($_POST['picID']),intval($_SESSION['userID']))){
    $db->addLike(intval($_POST['picID']),intval($_SESSION['userID']));
}else{
    $db->removeLike(intval($_SESSION['userID']),intval($_POST['picID']));
}
?>
