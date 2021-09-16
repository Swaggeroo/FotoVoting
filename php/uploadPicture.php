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

header('Content-Type: text/plain; charset=utf-8');


function saveCompressedImage($imgUrl, $outputLink, $quality){

          $info = getimagesize($imgUrl);
          if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($imgUrl);
          elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($imgUrl);
          if(imagejpeg($image, $outputLink, $quality)){
            imagedestroy($image);
            return true;
          }else{
            imagedestroy($image);
            return false;
          }
}

try {

    if (empty($_GET['project'])){
        $message = 'Invalid parameters.';
        echo $message;
        header("Location: ../sites/projectSelection.php?message=".$message);
        die();
    }

    $userID = $_SESSION["userID"];


    require "../php/dbConnection.php";

    $db = new db();
    if (!$db->projectExists($_GET['project'])) {
        $message = 'Project not found.';
        header("Location: ./projectSelection.php?message=".$message);
        die();
    }else{
        $projectName = $db->getProjectName($_GET['project']);
    }

    $project = $_GET['project'];

    $legalCheck = $_POST['legalCheck'];
    if ($legalCheck != 'true'){
        $message = 'You have to accept the requirements.';
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
        die();
    }

    if ($db->hasUploaded($userID,$project)){
        $message = 'You already uploaded a picture.';
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
        die();
    }

    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['upload']['error']) ||
        is_array($_FILES['upload']['error'])
    ) {
        $message = 'Invalid parameters.';
        echo $message;
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
        die();
    }


    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upload']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            $message = 'No file sent.';
            echo $message;
            header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
            die();
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $message = 'Exceeded filesize limit. (15 MB)';
            echo $message;
            header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
            die();
        default:
            $message = 'Unknown errors.';
            echo $message;
            header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
            die();
    }

    // You should also check filesize here.
    if ($_FILES['upload']['size'] > 15000000) {
        $message = 'Exceeded filesize limit. (15 MB)';
        echo $message;
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
        die();
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
            $finfo->file($_FILES['upload']['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
            ),
            true
        )) {
        $message = 'Invalid file format.';
        echo $message;
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
        die();
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $format = '../uploads/'.$projectName.'/%s.%s';
    $path = "../uploads/".$projectName."/";
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $fileName = sha1_file($_FILES['upload']['tmp_name']);
    if (!saveCompressedImage(
        $_FILES['upload']['tmp_name'],
        sprintf($format,
            $fileName,
            "jpeg"
        ), 95)) {
        $message = 'Failed to move uploaded file.';
        echo $message;
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
        die();
    }

    $fullFileName = $fileName.'.jpeg';

    $db->addPicture($fullFileName,$project,$userID);

    $message = 'File is uploaded successfully.';
    echo $message;
    header("Location: ../sites/votingPage.php?project=".$project."&message=".$message.$backtrackParameter);
    die();

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
