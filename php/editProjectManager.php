<?php
 require "checkPermission.php";


if(intval($_SESSION['userAccountLevel']) == 2){
    require "./dbConnection.php";
    $db = new db();
    $db->changeProject(intval(trim(stripslashes(htmlspecialchars($_POST['projectID'])))), trim(stripslashes(htmlspecialchars($_POST['newName']))));
}
?>
