<?php
if(!isset($_SESSION)){
 session_start();
}

if(!isset($_SESSION["userLoggedIn"])){
   $_SESSION["userLoggedIn"] = false;
}

if(!$_SESSION["userLoggedIn"]){
  echo "<script>alert('Du musst dich neu anmelden.');window.location.replace(\"../index.html\");</script>";
  die("Sie haben keine Berechtigung, auf diese Seite zuzugreifen");
}

//Check if terms have been accepted
if(!$_SESSION["acceptedTerms"]){
  include "#acceptTerms.php";
  die();
}

?>
