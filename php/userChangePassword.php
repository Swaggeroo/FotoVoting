<?php
   require "checkPermission.php";

   //check backtrack link
   $backtrack = "";
   //Save get parameter if valid
   if(isset($_GET["back"])){
    $backtrack = trim(stripslashes(htmlspecialchars($_GET["back"])));

    //Check if backtrackPage is valid
    $parsedUrl = parse_url($backtrack);
    if(isset($parsedUrl["host"])){

     if($parsedUrl["host"] != "mhsl.eu"){
       $backtrack = "";
    }
   }
   }

   //remove showChange pass parameter
   $backtrack = str_replace("&showChangePass=0", "", $backtrack);
   $backtrack = str_replace("?showChangePass=0", "", $backtrack);

       function error($errorMsg){
         global $backtrack;

         if(strstr($backtrack, "php?") == false){
           $showDialogParameter = "?showChangePass=1";
         }else{
           $showDialogParameter = "&showChangePass=1";
         }

         die("<script>
         alert('".$errorMsg."');
         window.location.replace('".$backtrack.$showDialogParameter."');
         </script>");
       }


  if($_SERVER["REQUEST_METHOD"] == "POST"){
     if(!isset($_POST["oldPassword"])){
       error("No old Password found");
     }

     if(!isset($_POST["newPassword"])){
       error("No new Password found");
     }

     if(!isset($_POST["newPasswordConfirm"])){
       error("No newPasswordconfirm found");
     }

     //Get data
     $oldPassword = trim(stripslashes(htmlspecialchars($_POST["oldPassword"])));
     $newPassword = trim(stripslashes(htmlspecialchars($_POST["newPassword"])));
     $newPasswordConfirm = trim(stripslashes(htmlspecialchars($_POST["newPasswordConfirm"])));

     //get db
     require "dbConnection.php";
     $db = new db();

     //Check if username matches old username
        $userID = $_SESSION["userID"];
        //get user password
        $userPassword = $db->getPasswordForUserID($userID);
        //Check password
        if(!password_verify($oldPassword, $userPassword)){
          error("Altes Passwort falsch!");
        }

        //check if passwort confirm is korrekt
        if($newPassword != $newPasswordConfirm){
          error("Neue Passwörter stimmen nicht überein!");
        }

        //Change password
          //Hash new password
          $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $db->changeUserPassword($userID, $newPassword);

        global $backtrack;
        echo "<script>
        alert('Erfolgreich geändert!');
        window.location.replace('".$backtrack."');
        </script>";

  }
 ?>
