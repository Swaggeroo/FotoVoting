<?php
  require "../php/checkPermission.php";

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

$backtrackParameter = "";
if(strlen($backtrack) > 0){
   $backtrackParameter = "&back=".$backtrack;
}

    require "../php/dbConnection.php";

    $db = new db();

    $project = trim(stripslashes(htmlspecialchars($_GET["project"])));

    if (!$db->projectExists($project)) {
        $message = 'Project not found.';
        header("Location: ./projectSelection.php?message=".$message);
        die();
    }else{
        $projectName = $db->getProjectName($project);
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="FotoVoting">
    <title>Add Picture (<?php echo htmlspecialchars($projectName)?>)</title>

    <!--basic Style-->
    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="../CSS/addPicture.css">

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
    <link rel="manifest" href="../manifest.webmanifest">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <?php
       include "#userNavigationBar.php";
     ?>

    <h1 align="center">Add Picture (<?php echo htmlspecialchars($projectName)?>)</h1>

    <div align="center">
        <form align="center" enctype="multipart/form-data" action="../php/uploadPicture.php?project=<?php echo htmlspecialchars($_GET['project']).$backtrackParameter; ?>" method="POST">
            <label for="upload" class="chosePicture">Choose Picture</label>
            <span id="file-chosen">No file chosen</span><br><br>
            <img src="" id="uploadPreview" width="90%" height="auto">
            <input type="hidden" name="Max_File_Size" value="15000000">
            <input type="file" name="upload" id="upload" accept=".jpg,.jpeg,.png" hidden required><br>
            <input type="checkbox" name="legalCheck" id="legalCheck" value="true" required>
            <label for="legalCheck">Das Bild entspricht den <a href="./uploadBedingungenSite.php" id="bedingungenLink">Upload-Bedingungen</a></label><br><br>
            <button type="submit" class="submitButton">Upload</button>
        </form>
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
            <a class="legalLink" href="./datenschutzSite.php">Datenschutz</a><br>
            <a class="legalLink" href="./nutzungsbedingungenSite.php">Nutzungsbedingungen</a><br>
            <a class="legalLink" href="./impressumSite.php">Impressum</a>
        </div>
    </footer>

    <!---Javascripts-->
    <script src="../scripts/addPicture.js" defer></script>
</body>
</html>
