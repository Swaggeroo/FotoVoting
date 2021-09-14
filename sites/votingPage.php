<?php
  require "../php/checkPermission.php";

  $backtrack = "";
 //Save get parameter if valid
 if(isset($_GET["back"])){
   $backtrack = trim(stripslashes(htmlspecialchars($_GET["back"])));

   //Check if backtrackPage is valid
   $parsedUrl = parse_url($backtrack);
   if(isset($parsedUrl["host"])){

    if($parsedUrl["host"] != $_SERVER['HTTP_HOST']){
      $backtrack = "";
   }
 }
}

$backtrackParameter = "";
if(strlen($backtrack) > 0){
   $backtrackParameter = "&back=".$backtrack;
}


  if (!empty($_GET['message'])) {
      echo "<script>alert(\"".trim(stripslashes(htmlspecialchars($_GET['message'])))."\");window.location.replace(\"./votingPage.php?project=".trim(stripslashes(htmlspecialchars($_GET['project']))).$backtrackParameter."\");</script>";
      if (empty($_GET['project'])) {
          $message = 'Invalid parameters.';
          header("Location: ./projectSelection.php?message=".$message);
          die();
      }
  }

  require "../php/dbConnection.php";

  $db = new db();
  if (!$db->projectExists(trim(stripslashes(htmlspecialchars($_GET['project']))))) {
      $message = 'Project not found.';
      header("Location: ./projectSelection.php?message=".$message);
      die();
  }else{
      $projectName = $db->getProjectName(trim(stripslashes(htmlspecialchars($_GET['project']))));
  }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="FotoVoting">
    <title>Voting (<?php echo htmlspecialchars($projectName)?>)</title>

    <!--basic Style-->
    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="../CSS/votingPage.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!---JavaScript's-->
    <script src="../scripts/votingPage.js" defer></script>

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

    <h1 align="center" id="projectTitle"><?php echo htmlspecialchars($projectName) ?></h1>
    <a id="addPictureButton" href="./addPicture.php?project=<?php echo htmlspecialchars($_GET["project"]) ?>">
        +
    </a>

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

                $pictureIDs = $db->getPictureIDs(intval($project));

                $pictureAuthorIDs = $db->getPictureAuthorIDs(intval($project));

                $userID = intval($_SESSION['userID']);

                for ($x = 0; $x < count($pictureIDs); $x++){
                    $bested = '';
                    $liked = '';
                    if (intval($db->getBestedID($userID,$project)) == intval($pictureIDs[$x]["picIDs"])){
                        $bested = 'bested';
                    }
                    if (intval($db->hasLiked(intval($pictureIDs[$x]["picIDs"]), $userID))){
                        $liked = 'liked';
                    }
                    echo "
                            <div class=\"picture-container\">
                                <div class=\"bildmitbildunterschrift card animate__animated animate__bounceIn\" style=\"margin: 1em;\">";
                    if(intval($_SESSION['userAccountLevel']) == 2){
                        echo"       <button class=\"deleteButton\" onclick=\"deletePic(".$pictureIDs[$x]["picIDs"].")\"><img src=\"../media/images/trashbin.png\" width='100%' height='100%'></button>";
                    }
                    echo "
                                    <img src=\"../uploads/".$projectName."/".$db->getPictureFileName(intval($pictureIDs[$x]["picIDs"]))."\" alt=\"Name\" style=\"width:100%;height:auto;\">
                                    <span class=\"nameTag\">".$db->getUserName(intval($pictureAuthorIDs[$x]["authIDs"]))."</span>
                                </div>
                                <div class=\"flex-container wrap row\">
                                    <button class=\"votingButton like card ".$liked."\" id='like".$pictureIDs[$x]["picIDs"]."' onclick=\"like(".$pictureIDs[$x]["picIDs"].")\">&#10084;Like (".$db->getLikes(intval($pictureIDs[$x]["picIDs"])).")</button>
                                    <button class=\"votingButton best card ".$bested."\" id='best".$pictureIDs[$x]["picIDs"]."' onclick=\"best(".$pictureIDs[$x]["picIDs"].",".$project.")\">&#11088;Best (".$db->getBests(intval($pictureIDs[$x]["picIDs"])).")</button>
                                </div>
                            </div>
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
            <a href="./datenschutzSite.php">Datenschutz</a>
        </div>
    </footer>
</body>
</html>
