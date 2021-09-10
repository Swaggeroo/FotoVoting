<?php
if(!isset($_SESSION)){
    session_start();
}
require "./dbConnection.php";
$db = new db();
$userID = intval($_SESSION['userID']);
$projectID = intval($_POST['projectID']);
$picID = intval($_POST['picID']);
if (!$db->userBested($projectID, $userID)){
    $db->addBest($picID,$userID);
}else{
    if ($picID == $db->getBestedID($userID,$projectID)){
        $db->removeBest($userID,$picID);
    }
}
?>