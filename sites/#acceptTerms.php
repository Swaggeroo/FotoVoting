<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datenschutz</title>

    <!--basic Style-->
    <link rel="stylesheet" href="../style.css">

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
    <link rel="manifest" href="../media/favicon/manifest.webmanifest">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

  <div align="center" style="width: 100%; margin-top: 2%;">
    Du musst die Nutzungsbedingungen und Datenschutzerklärung akzeptieren!
    <br>
    <br>
    <?php
      include "../legal/Datenschutz.html";
     ?>
     <br>
     <br>
     <button id='accept'>Akzeptieren</button><button id='cancel'>Ablehnen</button>
     <br>
     <br>
  </div>

  <script>
  document.getElementById("cancel").addEventListener("click",function (){
     alert('Du musst es akzepiteren um die Webseite zu nutzen!');
     location.replace('../logout.php');
  });

  document.getElementById("accept").addEventListener("click",function (){
     let oReq = new XMLHttpRequest();
     let parms = "userID=<?php echo $_SESSION["userID"]; ?>";
     oReq.addEventListener("load",function() {
          location.reload();
     })
     oReq.open("POST","../php/acceptTermsAjax.php");
     oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
     oReq.send(parms);
  })
  </script>
</body>

</html>
