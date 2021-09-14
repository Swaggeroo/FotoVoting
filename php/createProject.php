<?php

   require "checkPermission.php";

   $backtrack = "";
   $javascriptBack = "";

   if(isset($_GET["back"])){
     $backtrack = trim(stripslashes(htmlspecialchars($_GET["back"])));

     //Check if backtrackPage is valid
     $parsedUrl = parse_url($backtrack);
     if(isset($parsedUrl["host"])){

      if($parsedUrl["host"] != $_SERVER['HTTP_HOST']){
        $backtrack = "";
     }
   }

     //If no valid backtrack use history.back
     if(strlen($backtrack) > 0){
       $javascriptBack = "window.location.replace('".$backtrack."')";
     }else{
       $javascriptBack = "window.history.back()";
     }
   }

   function error($errorMsg){
     $javascriptBack = "";

     die("<script>
     alert('".$errorMsg."');
     ".$javascriptBack.";
     </script>");
    }

   if($_SERVER["REQUEST_METHOD"] == "POST"){
     //Check Data
     if(!isset($_POST["projectName"])){
       error("Got no Projectname!");
     }

     $projectName = trim(stripslashes(htmlspecialchars($_POST["projectName"])));

    //add to db
    require "dbConnection.php";

    $db = new db();

    $db->addProject($projectName);

    if(strlen($backtrack) > 0){
      $javascriptBack = "window.location.replace('".$backtrack."')";
    }else{
      $javascriptBack = "window.history.back()";
    }

    echo "<script>
    alert('Erfolgreich hinzugefügt!');
    ".$javascriptBack.";
    </script>";

  }else{
    error("No Data received!");
  }

 ?>
