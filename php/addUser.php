<?php

if(!isset($_SESSION)){
 session_start();
}

    function error($errorMsg){
      die("<script>
      alert('".$errorMsg."');
      window.location.replace('../sites/addNewUser.php');
      </script>");
    }

if($_SERVER["REQUEST_METHOD"] == "POST"){

   if(!isset($_POST["userName"])){
     error("Kein Benutzername angegeben!");
   }

   if(!isset($_POST["userPassword"])){
     error("Kein Passwort angegeben!");
   }

   if(!isset($_POST["userAccountLevel"])){
     error("Kein userAccountLevel übergeben");
   }

   $username = trim(stripslashes(htmlspecialchars($_POST["userName"])));
   $password = trim(stripslashes(htmlspecialchars($_POST["userPassword"])));
   $userAccountLevel = trim(stripslashes(htmlspecialchars($_POST["userAccountLevel"])));

   require "dbConnection.php";

   $db = new db();
   //Check if username exists
   if($db->userNameExists($username)){
     error("Benutzername existiert bereits!");
   }

   //check if user Accountlevel is valid
   if($userAccountLevel > $_SESSION["userAccountLevel"]){
     error("AccountLevel ungültig!");
   }

   //Hash password
   $passwordHash = password_hash($password, PASSWORD_DEFAULT);

   //Save to Database
   $db->addUser($username, $passwordHash, $userAccountLevel);

 }
 ?>
