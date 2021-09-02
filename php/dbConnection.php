<?php

class db {

private $_db_host = "";
private $_db_user = "";
private $_db_pass = "";
private $_db_name = "";

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


public function createAndCheckBasicDatabaseStructure(){
    $sqlStatements = array(
       ""
    );

    for($i = 0; $i < count($sqlStatements); $i++){
       $db->query($sqlStatements[$i]);
    }
}

?>
