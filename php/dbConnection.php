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
        "CREATE TABLE user(
            userID INTEGER NOT NULL AUTO_INCREMENT, 
            userName VARCHAR(255), 
            userPassword VARCHAR(300), 
            PRIMARY KEY (userID))
        ",
        "CREATE TABLE projects(
            projectID INT NOT NULL AUTO_INCREMENT, 
            projectName VARCHAR(500) NOT NULL, 
            PRIMARY KEY (projectID))
        ",
        "CREATE TABLE pictures( 
            picID INT NOT NULL AUTO_INCREMENT,
            picFileName VARCHAR(1000) NOT NULL, 
            projectID INT NOT NULL, 
            userID INT NOT NULL, 
            PRIMARY KEY (picID),
            FOREIGN KEY(userID) REFERENCES fotovote.user(userID),
            FOREIGN KEY(projectID) REFERENCES fotovote.projects(projectID)
            )
        ",
        "CREATE TABLE picturelikes( 
            pictureID INT NOT NULL , 
            userID INT NOT NULL ,
	        FOREIGN KEY (pictureID) REFERENCES fotovote.pictures(picID),
            FOREIGN KEY (userID) REFERENCES fotovote.user(userID)
        )",
        "CREATE TABLE picturebests(
            pictureID INT NOT NULL, 
            userID INT NOT NULL,
            projectID INT NOT NULL,
	        FOREIGN KEY (pictureID) REFERENCES fotovote.pictures(picID),
            FOREIGN KEY (userID) REFERENCES fotovote.user(userID),
            FOREIGN KEY (projectID) REFERENCES fotovote.projects(projectID)
        );"
    );

    for($i = 0; $i < count($sqlStatements); $i++){
       $this->dbKeyObject->query($sqlStatements[$i]);
    }
}

public function getUserIdForUsername($username){
     $sqlQuery = "SELECT userID FROM user WHERE userName = ?";

     $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
     $sqlStatement->bind_param("s", $username);
     $sqlStatement->execute();

     $result = $sqlStatement->get_result();

     $userID = $result->fetch_assoc()["userID"];

     $sqlStatement->close();

     return $userID;
}

public function getPasswordForUserID($userID){
     $sqlQuery = "SELECT userPassword FROM user WHERE userID = ?";

     $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
     $sqlStatement->bind_param("i", $userID);
     $sqlStatement->execute();

     $result = $sqlStatement->get_result();

     $password = $result->fetch_assoc()["userPassword"];

     $sqlStatement->close();

     return $password;
}

public function addUser($username, $password){
    $sqlQuery = "INSERT INTO user (userName, userPassword) VALUES (?, ?)";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("ss", $username, $password);
    if(!$sqlStatement->execute()){
      die("Error: ".$sqlStatement->error);
    }

    $sqlStatement->close();
}

public function getUserNameCount($userName){
   $sqlQuery = "SELECT COUNT(userName) AS userNameCount FROM user WHERE userName = ?";

   $statement = $this->dbKeyObject->prepare($sqlQuery);
   $statement->bind_param("s", $userName);
   $statement->execute();

   $result = $statement->get_result();

   $userNameCount = $result->fetch_assoc()["userNameCount"];

   $statement->close();

   return $userNameCount;
}

public function userNameExists($userName){
   $userNameCount = $this->getUserNameCount($userName);

   if($userNameCount >= 1){
     return true;
   }else{
     return false;
   }

}

public function getLikes($picID){
    $sqlQuery = "SELECT COUNT(userID) AS likeCount FROM picturelikes WHERE pictureID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $picID);
    $statement->execute();

    $result = $statement->get_result();

    $likeCount = $result->fetch_assoc()["likeCount"];

    $statement->close();

    return $likeCount;
}

public function getBests($picID){
    $sqlQuery = "SELECT COUNT(userID) AS bestCount FROM picturebests WHERE pictureID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $picID);
    $statement->execute();

    $result = $statement->get_result();

    $bestCount = $result->fetch_assoc()["bestCount"];

    $statement->close();

    return $bestCount;
}

public function hasLiked($picID, $userID){
    $sqlQuery = "SELECT COUNT(userID) AS userIDCount FROM picturelikes WHERE userID = ? AND pictureID = ?";
    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("ii", $userID, $picID);
    $statement->execute();

    $result = $statement->get_result();

    $haveLiked = $result->fetch_assoc()["userIDCount"];

    $statement->close();

    if($haveLiked >= 1){
        return true;
    }else{
        return false;
    }
}

public function addLike($picID, $userID){
    if($this->hasLiked($picID,$userID)){
        return false;
    }else{
        $sqlQuery = "INSERT INTO picturelikes (pictureID, userID) VALUES (?, ?)";

        $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
        $sqlStatement->bind_param("ii", $picID, $userID);
        if(!$sqlStatement->execute()){
            die("Error: ".$sqlStatement->error);
        }

        $sqlStatement->close();
        return true;
    }
}

public function getProjectIDFromPicID($picID){
    $sqlQuery = "SELECT projectID AS projectID FROM pictures WHERE pictureID = ?";
    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $picID);
    $statement->execute();

    $result = $statement->get_result();

    $projectID = $result->fetch_assoc()["projectID"];

    $statement->close();
    return $projectID;
}

public function userBested($projectID, $userID){
    $sqlQuery = "SELECT COUNT(pictureID) AS bestCount FROM picturebests WHERE projectID = ? AND userID = ?";
    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("ii", $projectID, $userID);
    $statement->execute();

    $result = $statement->get_result();

    $bestCount = $result->fetch_assoc()["bestCount"];

    $statement->close();
    if ($bestCount >= 1){
        return true;
    }else{
        return false;
    }
}

public function addBest($picID, $userID){
    $projectID = $this->getProjectIDFromPicID($picID);

    if (!$this->userBested($projectID,$userID)){
        $sqlQuery = "INSERT INTO pictureBests (pictureID, userID, projectID) VALUES (?, ?, ?)";

        $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
        $sqlStatement->bind_param("iii", $picID, $userID, $projectID);
        if(!$sqlStatement->execute()){
            die("Error: ".$sqlStatement->error);
        }

        $sqlStatement->close();
        return true;
    }else{
        return false;
    }
}

public function getProjectCount($projectID){
    $sqlQuery = "SELECT COUNT(projectID) AS projectCount FROM projects WHERE projectID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $projectID);
    $statement->execute();

    $result = $statement->get_result();

    $projectCount = $result->fetch_assoc()["projectCount"];

    $statement->close();

    return $projectCount;
}

public function projectExists($projectID){
    $projectCount = $this->getProjectCount($projectID);

    if($projectCount >= 1){
        return true;
    }else{
        return false;
    }
}

public function getProjectName($projectID){
    $sqlQuery = "SELECT projectName AS projectName FROM projects WHERE projectID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $projectID);
    $statement->execute();

    $result = $statement->get_result();

    $projectName = $result->fetch_assoc()["projectName"];

    $statement->close();

    return $projectName;
}

public function getProjectNames()
{
    $sqlQuery = "SELECT projectName AS projectNames FROM projects";

    $result = $this->dbKeyObject->query($sqlQuery);

    $rows = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($rows, $row);
    }
    return $rows;
}

public function getProjectIDs()
{
    $sqlQuery = "SELECT projectID AS projectIDs FROM projects";

    $result = $this->dbKeyObject->query($sqlQuery);

    $rows = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($rows, $row);
    }
    return $rows;
}

public function getPictureIDs($projectID){
    $sqlQuery = "SELECT picID AS picIDs FROM pictures WHERE projectID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $projectID);
    $statement->execute();

    $result = $statement->get_result();

    $rows = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($rows, $row);
    }
    return $rows;
}

public function getPictureAuthorIDs($projectID){
    $sqlQuery = "SELECT authID AS authIDs FROM pictures WHERE projectID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $projectID);
    $statement->execute();

    $result = $statement->get_result();

    $rows = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($rows, $row);
    }
    return $rows;
}

public function addPicture($fileName,$projectID,$userID){
    $sqlQuery = "INSERT INTO pictures (picFileName, userID, projectID) VALUES (?, ?, ?)";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("sii", $fileName, $userID, $projectID);
    if(!$sqlStatement->execute()){
        die("Error: ".$sqlStatement->error);
    }

    $sqlStatement->close();
    return true;
}

public function getUserName($userID) {
    $sqlQuery = "SELECT userName AS userName FROM user WHERE userID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $userID);
    $statement->execute();

    $result = $statement->get_result();

    $userName = $result->fetch_assoc()["userName"];

    $statement->close();

    return $userName;
}

public function hasUploaded($userID,$projectID){
    $sqlQuery = "SELECT COUNT(picID) AS uploadCount FROM pictures WHERE projectID = ? AND userID = ?";
    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("ii", $projectID, $userID);
    $statement->execute();

    $result = $statement->get_result();

    $uploadCount = $result->fetch_assoc()["uploadCount"];

    $statement->close();
    if ($uploadCount >= 1){
        return true;
    }else{
        return false;
    }
}

    //TODO Remove Like
    //TODO Remove Best
    //TODO Remove Picture
}
?>
