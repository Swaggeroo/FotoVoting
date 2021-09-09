<?php
  //require "../php/checkPermission.php";
  if (!empty($_GET['message'])) {
      echo "<script>alert(\"".trim(stripslashes(htmlspecialchars($_GET['message'])))."\");window.location.replace(\"./projectSelection.php\");</script>";
  }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Projekte</title>

    <!--basic Style-->
    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="../CSS/projectSelection.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!--favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="../media/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../media/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../media/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../media/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../media/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../media/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../media/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../media/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../media/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../media/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../media/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../media/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../media/favicon/favicon-16x16.png">
    <link rel="manifest" href="../media/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

  <?php
     include "#userNavigationBar.php";
   ?>

    <h1 align = center>Projekte</h1>
    <div align="center" style="width: 100%;">
        <div id="projekte" style="width: 90%;">
            <?php
                require "../php/dbConnection.php";

                $db = new db();
                $projectIDs = $db->getProjectIDs();
                $projectNames = $db->getProjectNames();

                for ($x = 0; $x < count($projectIDs); $x++){
                    echo "
                        <a href=\"./votingPage.php?project=".$projectIDs[$x]["projectIDs"]."\">
                            <div class=\"card projectButton\">
                                <p>".$projectNames[$x]["projectNames"]."</p>
                            </div>
                        </a>
                    ";
                }

            ?>
        </div>
    </div>

    <hr>
    <footer>
        This Website was made by:
        <br>
        <div align="center">
            <a href="https://github.com/Swaggeroo">
                <img src="https://img.shields.io/github/followers/Swaggeroo?color=green&label=Swaggeroo&logo=github&style=flat-square" alt="Swaggeroo">
            </a>
            <a href="https://github.com/BumBumGame">
                <img src="https://img.shields.io/github/followers/BumBumGame?color=purple&label=BumBumGame&logo=github&style=flat-square" alt="BumBumGame">
            </a><br>
            <a href="./Datenschutz.html">Datenschutz</a>
        </div>
    </footer>

    <!---Javascripts-->
    <script src="../scripts/projectSelection.js" defer></script>
</body>
</html>
