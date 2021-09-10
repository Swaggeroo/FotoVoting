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
    //TODO Nutzungsbedingungen einfügen
    echo "<script>
    document.getElementById(\"cancel\").addEventListener(\"click\",function (){       
       alert('Du musst es akzepiteren um die Webseite zu nutzen!');
       location.replace('index.html');
   });

   document.getElementById(\"accept\").addEventListener(\"click\",function (){
       let oReq = new XMLHttpRequest();
       let parms = \"userID=".$userID."\";
       oReq.addEventListener(\"load\",function() {
            alert(\"Erfolgreich, bitte melde dich neu an\");
            location.replace('index.html');
       })
       oReq.open(\"POST\",\"./php/acceptTermsAjax.php\");
       oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
       oReq.send(parms);
       //location.replace('index.html');
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
