<?php
 require "checkPermission.php";


if(intval($_SESSION['userAccountLevel']) == 2){
    require "./dbConnection.php";
    $db = new db();
    $uloaddir = '../uploads/';
    rename(realpath($uloaddir).'/'.$db->getProjectName(intval(trim(stripslashes(htmlspecialchars($_POST['projectID']))))),realpath($uloaddir).'/'.trim(stripslashes(htmlspecialchars($_POST['newName']))));
    $db->changeProject(intval(trim(stripslashes(htmlspecialchars($_POST['projectID'])))), trim(stripslashes(htmlspecialchars($_POST['newName']))));
}
?>
