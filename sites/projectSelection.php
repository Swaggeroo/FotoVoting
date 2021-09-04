<?php
  //TODO
  //require "../php/checkPermission.php";
  if (!empty($_GET['message'])) {
      echo "<script>alert(\"".$_GET['message']."\");</script>";
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

</head>
<body>
    <h1 align = center>Projekte</h1>
    <div align="center" style="width: 100%;">
        <div id="projekte" style="width: 90%;">
            <?php
                $path = "../uploads";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $contentArray = scandir($path);
                foreach($contentArray as $project){
                    if (!is_dir($project)){
                        echo "<a href=\"./votingPage.php?project=$project\">";
                        echo "<div class=\"card projectButton\">";
                        echo"<p>$project</p>";
                        echo"</div>";
                        echo"</a>";
                    }
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
            </a>
        </div>
    </footer>

    <!---Javascripts-->
    <script src="../scripts/projectSelection.js" defer></script>
</body>
</html>
