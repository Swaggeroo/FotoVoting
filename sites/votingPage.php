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
    <title>Voting (<?php echo $_GET['project']?>)</title>

    <!--basic Style-->
    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="../CSS/votingPage.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
    <a href="./addPicture.php?project=<?php echo $_GET["project"] ?>" style="position: absolute; top: 15px; margin-left: 85%; font-size: xxx-large" >
        +
    </a>
    <h1 align="center" id="projectTitle"><?php echo $_GET['project'] ?></h1>

    <div align="center" style="width: 100%;">
        <div id="pictures" style="width: 90%;">
            <?php
                $project = $_GET["project"];
                if (empty($project)){
                    $message = 'Invalid parameters.';
                    echo $message;
                    header("Location: ./projectSelection.php?message=".$message);
                    die();
                }

                $pictures = scandir("../uploads/".$project);

                foreach ($pictures as $picture) {
                    if (!is_dir($picture)){
                        echo "
                            <div class=\"picture-container\">   
                                <div class=\"bildmitbildunterschrift card animate__animated animate__bounceIn\" style=\"margin: 1em;\">
                                    <img src=\"../uploads/".$project."/".$picture."\" alt=\"Name\" style=\"width:100%;height:auto;\">
                                    <span class=\"nameTag\">".$picture."</span>
                                </div>
                                <div class=\"flex-container wrap row\">
                                    <button class=\"votingButton like card\">&#10084;Like</button>
                                    <button class=\"votingButton best card\">&#11088;Best</button>
                                </div>
                            </div> 
                        ";
                        //TODO Get Username - On nametag and alt
                        //TODO Button action
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
    <script src="../scripts/votingPage.js" defer></script>
</body>
</html>
