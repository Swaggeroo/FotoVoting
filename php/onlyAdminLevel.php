<?php

if(!isset($_SESSION)){
 session_start();
}

//Check if user has allowed account level
if($_SESSION["userAccountLevel"] < 2){
  die("<script>alert('Du Hast keine Berechtigung für diesen Bereich!');window.location.replace(\"../index.html\");</script>");
}
 ?>
