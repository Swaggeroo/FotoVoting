<?php

require "checkPermission.php";

function error($errorMsg){
  die("<script>
  alert('".$errorMsg."');
  window.location.replace('../sites/manageUsers.php');
  </script>");
 }

  if($_SERVER["REQUEST_METHOD"] == "POST"){
     //Check if data is there
     if(!isset($_POST["userID"])){
       error("Keine Daten übergeben!");
     }

     //Get Data
     $userID = trim(stripslashes(htmlspecialchars($_POST["userID"])));

     require "dbConnection.php";
     //Delete user
     $db = new db();

     $db->deleteUser($userID);

     //Go back
     echo "<script>
      alert('Erfolgreich gelöscht!');
      window.location.replace('../sites/manageUsers.php');
     </script>";

  }

 ?>
