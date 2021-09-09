<?php
if(!isset($_SESSION)){
 session_start();
}

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

//Check if User exists in database

$db = new db();

if(!$db->userNameExists($username)){
  die("<script>
   alert('Benutzername nicht gefunuden');
   location.href= 'index.html';
  </script>");
}

$userID = $db->getUserIdForUsername($username);

$serverPasswordHash = $db->getPasswordForUserID($userID);

if (!$db->hasAcceptedTerms($userID)){
    echo"
        Du musst die <a href=\"./sites/Datenschutz.html\">Nutzungsbedingungen</a> und <a href=\"./sites/Datenschutz.html\">Datenschutzerklärung</a> akzeptieren.<br>
        <button id='accept'>Akzeptieren</button><button id='cancel'>Ablehnen</button> 
    ";
    echo "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>";
    echo "<script>
    document.getElementById(\"cancel\").addEventListener(\"click\",function (){       
       alert('Du musst es akzepiteren um die Webseite zu nutzen!');
       location.replace('index.html');
   });

   document.getElementById(\"accept\").addEventListener(\"click\",function (){
       jQuery.ajax({
            type: \"POST\",
            url: './php/acceptTermsAjax.php',
            dataType: 'json',
            data: {functionname: 'accept', arguments: [".$userID."]},
        
            success: function (obj, textstatus) {
                          if( !('error' in obj) ) {
                              alert(\"Erfolgreich, bitte melde dich neu an\");
                              location.replace('index.html');
                          }
                          else {
                              console.log(obj.error);
                          }
                    }
        });
   })
   //location.replace('index.html');
    </script>";
}else{
    //Check Password
    if(password_verify($password, $serverPasswordHash)){
        $_SESSION["userLoggedIn"] = true;
        $_SESSION["userID"] = $userID;
        $_SESSION["userAccountLevel"] = $db->getUserAccountLevel($userID);
        echo "<script>
    location.replace('sites/projectSelection.php');
  </script>";
    }else{
        echo "<script>
   alert('Falsches Passwort!');
   location.replace('index.html');
  </script>";
    }
}



}


?>
