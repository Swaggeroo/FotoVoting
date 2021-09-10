<?php
if(!isset($_SESSION)){
 session_start();
}

if(!isset($_SESSION["userLoggedIn"])){
   $_SESSION["userLoggedIn"] = false;
}

if(!$_SESSION["userLoggedIn"]){
  die("Sie haben keine Berechtigung, auf diese Seite zuzugreifen");
}

require "./dbConnection.php";
$db = new db();
$db->acceptTerms(intval($_POST['userID']));

$_SESSION["acceptedTerms"] = true;
?>
