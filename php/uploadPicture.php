<?php
//TODO
//require "../php/checkPermission.php";

header('Content-Type: text/plain; charset=utf-8');

try {
    if (empty($_GET['project'])){
        $message = 'Invalid parameters.';
        echo $message;
        header("Location: ../sites/projectSelection.php?message=".$message);
        die();
    }

    $project = $_GET['project'];

    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['upload']['error']) ||
        is_array($_FILES['upload']['error'])
    ) {
        $message = 'Invalid parameters.';
        echo $message;
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message);
        die();
    }


    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upload']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            $message = 'No file sent.';
            echo $message;
            header("Location: ../sites/votingPage.php?project=".$project."&message=".$message);
            die();
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $message = 'Exceeded filesize limit. (15 MB)';
            echo $message;
            header("Location: ../sites/votingPage.php?project=".$project."&message=".$message);
            die();
        default:
            $message = 'Unknown errors.';
            echo $message;
            header("Location: ../sites/votingPage.php?project=".$project."&message=".$message);
            die();
    }

    // You should also check filesize here.
    if ($_FILES['upload']['size'] > 15000000) {
        $message = 'Exceeded filesize limit. (15 MB)';
        echo $message;
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message);
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
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message);
        die();
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $format = '../uploads/'.$project.'/%s.%s';
    $path = "../uploads/".$project."/";
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if (!move_uploaded_file(
        $_FILES['upload']['tmp_name'],
        sprintf($format,
            sha1_file($_FILES['upload']['tmp_name']),
            $ext
        )
    )) {
        $message = 'Failed to move uploaded file.';
        echo $message;
        header("Location: ../sites/votingPage.php?project=".$project."&message=".$message);
        die();
    }

    $message = 'File is uploaded successfully.';
    echo $message;
    header("Location: ../sites/votingPage.php?project=".$project."&message=".$message);
    die();

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
