<?php
require "./dbConnection.php";
$db = new db();
$db->acceptTerms(intval($_POST['userID']));
?>