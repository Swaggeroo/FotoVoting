<?php

   require "checkPermission.php";

   require "../php/onlyAdminLevel.php";

   function error($errorMsg){
     die("<script>
     alert('".$errorMsg."');
     window.location.replace('../sites/manageUsers.php');
     </script>");
   }

  if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(!isset($_POST["userID"])){
       error("userID not set!");
    }

    if(!isset($_POST["operation"])){
      error("operration not set!");
    }

    //Get user ID and operation
    $userID = trim(stripslashes(htmlspecialchars($_POST["userID"])));
    $operation = trim(stripslashes(htmlspecialchars($_POST["operation"])));

    //Determine operation
    switch ($operation) {
      case 'password':
        //Check if password is set
        if(!isset($_POST["newPassword"])){
          error("No new password set!");
        }

        //Get new password
        $newPassword = trim(stripslashes(htmlspecialchars($_POST["newPassword"])));

        //Hash Password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        //Update userPassword
        $db = new db();

        $db->changeUserPassword($userID, $hashedPassword);

        echo "<script>
         alert('Password Erfolgreich geändert!');
         window.location.replace('../sites/manageUsers.php');
        </script>";

        break;

      case 'username':
      //Check if new username is set
      if(!isset($_POST["newUsername"])){
         error("No new Username set!");
      }

      //Get username
      $newUsername = trim(stripslashes(htmlspecialchars($_POST["newUsername"])));

      //save username if doesnt exists
      $db = new db();

      if($db->userNameExists($newUsername)){
        error("Neuer Benutzername ist bereits vergeben!");
      }

      //Update username
      $db->changeUsersUserName($userID, $newUsername);

      echo "<script>
       alert('Benutzername Erfolgreich geändert!');
       window.location.replace('../sites/manageUsers.php');
      </script>";

      break;

      default:
      error("Operation invalid!");
      break;
    }
  }

 ?>
