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

  if($parsedUrl["host"] != "mhsl.eu"){
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
      window.location.replace('../sites/manageUsers.php".$backtrackLink."');
     </script>";

  }

 ?>
