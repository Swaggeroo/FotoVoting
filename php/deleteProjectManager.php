<?php
 require "checkPermission.php";


if(intval($_SESSION['userAccountLevel']) == 2){
    require "./dbConnection.php";
    $db = new db();
    $db->deleteProject(intval(trim(stripslashes(htmlspecialchars($_POST['projectID'])))));
}
?>
