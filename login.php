<?php
if(!isset($_SESSION)){
 session_start();
}

   if($_SERVER["REQUEST_METHOD"] == "POST"){

require "php/dbConnection.php";

//check if variables are set
if(!isset($_POST["username"])){
  die("<script>
   alert('Error: No Username');
   location.replace('index.php');
  </script>");
}

if(!isset($_POST["userpassword"])){
  die("<script>
   alert('Error: No password');
   location.replace('index.php');
  </script>");
}

//get variables
$username = stripslashes(htmlspecialchars(trim($_POST["username"])));
$password = stripslashes(htmlspecialchars(trim($_POST["userpassword"])));

//Check if User exists in database

$db = new db();

if(!$db->userNameExists($username)){
  die("<script>
   alert('Benutzername nicht gefunden');
   location.replace('index.php');
  </script>");
}

$userID = $db->getUserIdForUsername($username);

$serverPasswordHash = $db->getPasswordForUserID($userID);

    //Check Password
    if(password_verify($password, $serverPasswordHash)){
        $_SESSION["userLoggedIn"] = true;
        $_SESSION["userID"] = $userID;
        $_SESSION["userAccountLevel"] = $db->getUserAccountLevel($userID);
        $_SESSION["username"] = $username;

        if (!$db->hasAcceptedTerms($userID)){
         $_SESSION["acceptedTerms"] = false;
        }else{
         $_SESSION["acceptedTerms"] = true;
        }

        echo "<script>
        location.replace('sites/projectSelection.php');
       </script>";

    }else{
        echo "<script>
   alert('Falsches Passwort!');
   location.replace('index.php');
  </script>";
    }



}


?>
