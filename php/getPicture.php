<?php
require "checkPermission.php";

$uploadPath = "../uploads";

//Get data for png
if(!isset($_GET["projectName"])){
 goto leave;
}

if(!isset($_GET["fileName"])){
 goto leave;
}

//Save get data
$projectName = trim(stripslashes(htmlspecialchars($_GET["projectName"])));
$fileName = trim(stripslashes(htmlspecialchars($_GET["fileName"])));

$file_out = $uploadPath."/".$projectName."/".$fileName;

if (file_exists($file_out)) {

   $image_info = getimagesize($file_out);

   //Set the content-type header as appropriate
   header('Content-Type: ' . $image_info['mime']);

   //Set the content-length header
   header('Content-Length: ' . filesize($file_out));

   //Write the image bytes to the client
   readfile($file_out);
}
else { // Image file not found
    leave:
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
}
