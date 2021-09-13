<?php
if(!isset($_SESSION)){
    session_start();
}
if(intval($_SESSION['userAccountLevel']) == 2){
    require "./dbConnection.php";
    $db = new db();
    $db->changeProject(intval($_POST['projectID']),intval($_POST['newName']));
}
?>