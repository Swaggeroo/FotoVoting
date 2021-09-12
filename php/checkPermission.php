<?php
if(!isset($_SESSION)){
 session_start();
}

if(!isset($_SESSION["userLoggedIn"])){
   $_SESSION["userLoggedIn"] = false;
}

if(!$_SESSION["userLoggedIn"]){
  die("<script>alert('Du musst erst anmelden.');window.location.replace(\"../index.html\");</script>");
}

//Check if terms have been accepted
if(!$_SESSION["acceptedTerms"]){
  include "#acceptTerms.php";
  die();
}

?>
