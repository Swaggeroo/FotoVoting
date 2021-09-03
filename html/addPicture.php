<?php
  require "../php/checkPermission.php";
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Add Picture</title>

    <!--basic Style-->
    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="../CSS/addPicture.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
    <h1 align="center">Add Picture</h1>

    <form align="center">
        <label for="upload">Choose Picture</label>
        <span id="file-chosen">No file chosen</span><br><br>
        <img src="" id="uploadPreview" width="90%" height="auto">
        <input type="file" id="upload" accept=".jpg,.jpeg,.png" hidden><br><br>
        <button type="submit" class="submitButton">Upload</button>
    </form>

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
            </a>
        </div>
    </footer>

    <!---Javascripts-->
    <script src="../scripts/addPicture.js" defer></script>
</body>
</html>