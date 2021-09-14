<?php

   require "checkPermission.php";

   require "../php/onlyAdminLevel.php";

   $backtrack = "";
  //Save get parameter if valid
  if(isset($_GET["back"])){
    $backtrack = trim(stripslashes(htmlspecialchars($_GET["back"])));

    //Check if backtrackPage is valid
    $parsedUrl = parse_url($backtrack);
    if(isset($parsedUrl["host"])){

     if($parsedUrl["host"] != $_SERVER['HTTP_HOST']){
       $backtrack = "";
    }
  }
}

if(strlen($backtrack) > 0){
$backtrackLink = "?back=".$backtrack;
}

   function error($errorMsg){
     die("<script>
     alert('".$errorMsg."');
     window.location.replace('../sites/manageUsers.php".$backtrackLink."');
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

    require "dbConnection.php";

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
        window.location.replace('../sites/manageUsers.php".$backtrackLink."');
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
       window.location.replace('../sites/manageUsers.php".$backtrackLink."');
      </script>";

      break;

      case 'userAccountLevel':

      //Check if accountlevel is set
      if(!isset($_POST["newUserAccountLevel"])){
        error("No UserAccountLevel set!");
      }

      $newUserAccountLevel = trim(stripslashes(htmlspecialchars($_POST["newUserAccountLevel"])));

      //Save userAccount level if not bigger thant own
      if($newUserAccountLevel > $_SESSION["userAccountLevel"]){
        error("Not allowed to set this Accountlevel");
      }

      $db = new db();

      $db->changeUserAccoutLevel($userID, $newUserAccountLevel);


      break;

      default:
      error("Operation invalid!");
      break;
    }

    echo "<script>
    alert('Erfolgreich geändert!');
    window.location.replace('../sites/manageUsers.php".$backtrackLink."');
    </script>";
  }

 ?>
