<?php
session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST"){

require "php/dbConnection.php";

//check if variables are set
if(!isset($_POST["username"])){
  die("Error: No Username");
}

if(!isset($_POST["userpassword"])){
  die("Error: No Password");
}

//get variables
$username = stripslashes(htmlspecialchars(trim($_POST["username"])));
$password = stripslashes(htmlspecialchars(trim($_POST["userpassword"])));



}


?>
