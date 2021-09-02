<?php

class db {

private $_db_host = "localhost";
private $_db_user = "fotovote";
private $_db_pass = "zfN8ccEN(_f6q7uV";
private $_db_name = "fotovote";

private $dbKeyObject;


public function __construct(){
   $this->dbKeyObject = new mysqli($this->{"_db_host"}, $this->{"_db_user"}, $this->{"_db_pass"}, $this->{"_db_name"});

  if($this->dbKeyObject->connect_error){
    die('Error: Keine Verbindung zur Datenbank!'. $this->dbKeyObject->connect_error);
  }

    $this->dbKeyObject->query("SET NAMES 'utf8'");
}

public function __destruct(){
  $this->dbKeyObject->close();
}


public function createBasicDatabaseStructure(){
    $sqlStatements = array(
       "CREATE TABLE user (userID INTEGER NOT NULL AUTO_INCREMENT, userName VARCHAR(255), userPassword VARCHAR(300), PRIMARY KEY (userID))"
    );

    for($i = 0; $i < count($sqlStatements); $i++){
       $db->query($sqlStatements[$i]);
    }
}

?>
