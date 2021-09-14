<?php
   if(!isset($_SESSION)){
    session_start();
   }

   //If session is still logged in: auto log in
   //else: destroy session
   if(isset($_SESSION["userLoggedIn"])){
     //if userLoggedin and every other one is set: log in
     if($_SESSION["userLoggedIn"] == true && isset($_SESSION["userID"]) && isset($_SESSION["userAccountLevel"]) && isset($_SESSION["acceptedTerms"])){
       die("
       <script>
        window.location.replace('sites/projectSelection.php');
       </script>
       ");
     }

   }

   session_destroy();

 ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Foto Voting 13BG 2021</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--basic Style-->
    <link rel="stylesheet" href="style.css"/>
    <!--extended Style-->
    <link rel="stylesheet" href="CSS/login.css"/>

    <!--favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="./media/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./media/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./media/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./media/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./media/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./media/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./media/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./media/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./media/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="./media/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./media/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./media/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./media/favicon/favicon-16x16.png">
    <link rel="manifest" href="media/favicon/manifest.webmanifest">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <h1>Login</h1>

    <div align="center">
        <form id="loginForm" action="login.php" method="post">
            <input type="text" name="username" id="usernameInput" placeholder="Benutzername" required/>
            <br>
            <br>
            <input type="password" name="userpassword" id="userpasswordInput" placeholder="Passwort" required/>
            <br>
            <br>
            <input id="loginButton" type="submit" value="Login" />
        </form>
    </div>

    <hr>
    <footer>
        This Website was made by:
        <br>
        <div align="center">
            <a href="https://github.com/Swaggeroo">
                <img src="https://img.shields.io/github/followers/Swaggeroo?color=green&label=Swaggeroo&logo=github&style=flat-square">
            </a>
            <a href="https://github.com/BumBumGame">
                <img src="https://img.shields.io/github/followers/BumBumGame?color=purple&label=BumBumGame&logo=github&style=flat-square">
            </a><br>
            <a href="./sites/datenschutzSite.php">Datenschutz</a>
            <!--TODO Nutzungsbedingungen-->
        </div>
    </footer>

      <!---Javascripts-->
      <script src="main.js"></script>
</body>
</html>
