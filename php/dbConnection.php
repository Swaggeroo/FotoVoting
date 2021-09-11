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
            userAccountLevel INTEGER NOT NULL,
            acceptedTerms BOOL NOT NULL DEFAULT false,
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

public function getUserIdForUsername($username):int{
     $sqlQuery = "SELECT userID FROM user WHERE userName = ?";

     $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
     $sqlStatement->bind_param("s", $username);
     $sqlStatement->execute();

     $result = $sqlStatement->get_result();

     $userID = $result->fetch_assoc()["userID"];

     $sqlStatement->close();

     return $userID;
}

public function getPasswordForUserID($userID):String{
     $sqlQuery = "SELECT userPassword FROM user WHERE userID = ?";

     $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
     $sqlStatement->bind_param("i", $userID);
     $sqlStatement->execute();

     $result = $sqlStatement->get_result();

     $password = $result->fetch_assoc()["userPassword"];

     $sqlStatement->close();

     return $password;
}

public function addUser($username, $password, $userAccountLevel){
    $sqlQuery = "INSERT INTO user (userName, userPassword, userAccountLevel) VALUES (?, ?, ?)";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("ssi", $username, $password, $userAccountLevel);
    if(!$sqlStatement->execute()){
      die("Error: ".$sqlStatement->error);
    }

    $sqlStatement->close();
}

public function deleteUser($userID){
    //DELETE User Content
    //bests
    $sqlQuery = "DELETE FROM picturebests WHERE userID = ?";
    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $userID);
    $sqlStatement->execute();
    $sqlStatement->close();

    //likes
    $sqlQuery = "DELETE FROM picturelikes WHERE userID = ?";
    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $userID);
    $sqlStatement->execute();
    $sqlStatement->close();

    //pictures
    $sqlQuery = "DELETE FROM pictures WHERE userID = ?";
    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $userID);
    $sqlStatement->execute();
    $sqlStatement->close();
    //TODO also from Filesystem

    //Delete User
   $sqlQuery = "DELETE FROM user WHERE userID = ?";

   $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
   $sqlStatement->bind_param("i", $userID);
   $sqlStatement->execute();

   $sqlStatement->close();
}

public function changeUserPassword($userID, $newPassword){
   $sqlQuery = "UPDATE user SET userPassword = ? WHERE userID = ?";

   $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
   $sqlStatement->bind_param("is", $userID, $newPassword);
   $sqlStatement->execute();

   $sqlStatement->close();
}

public function changeUsersUserName($userID, $newUsername){
   $sqlQuery = "UPDATE user SET userName = ? WHERE userID = ?";

   $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
   $sqlStatement->bind_param("is", $userID, $newUsername);
   $sqlStatement->execute();

   $sqlStatement->close();
}

public function getAllUsers(): array
{
   $sqlQuery = "SELECT userName,userID,userAccountLevel FROM user";

   $result = $this->dbKeyObject->query($sqlQuery);

   $outputArray = array();

   $counter = 0;
   while($row = $result->fetch_assoc()){
      $outputArray[$counter][0] = $row["userName"];
      $outputArray[$counter][1] = $row["userID"];
      $outputArray[$counter][2] = $row["userAccountLevel"];

      $counter++;
   }

   return $outputArray;

}

public function getUserNameCount($userName):int{
   $sqlQuery = "SELECT COUNT(userName) AS userNameCount FROM user WHERE userName = ?";

   $statement = $this->dbKeyObject->prepare($sqlQuery);
   $statement->bind_param("s", $userName);
   $statement->execute();

   $result = $statement->get_result();

   $userNameCount = $result->fetch_assoc()["userNameCount"];

   $statement->close();

   return $userNameCount;
}

public function userNameExists($userName):bool{
   $userNameCount = $this->getUserNameCount($userName);

   if($userNameCount >= 1){
     return true;
   }else{
     return false;
   }

}

public function getLikes($picID):int{
    $sqlQuery = "SELECT COUNT(userID) AS likeCount FROM picturelikes WHERE pictureID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $picID);
    $statement->execute();

    $result = $statement->get_result();

    $likeCount = $result->fetch_assoc()["likeCount"];

    $statement->close();

    return $likeCount;
}

public function getBests($picID):int{
    $sqlQuery = "SELECT COUNT(userID) AS bestCount FROM picturebests WHERE pictureID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $picID);
    $statement->execute();

    $result = $statement->get_result();

    $bestCount = $result->fetch_assoc()["bestCount"];

    $statement->close();

    return $bestCount;
}

public function hasLiked($picID, $userID):bool{
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

public function addLike($picID, $userID):bool{
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

public function getProjectIDFromPicID($picID):int{
    $sqlQuery = "SELECT projectID AS projectID FROM pictures WHERE picID = ?";
    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $picID);
    $statement->execute();

    $result = $statement->get_result();

    $projectID = $result->fetch_assoc()["projectID"];

    $statement->close();
    return $projectID;
}

public function userBested($projectID, $userID):bool{
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

public function addBest($picID, $userID):bool{
    $projectID = $this->getProjectIDFromPicID($picID);

    if (!$this->userBested($projectID,$userID)){
        $sqlQuery = "INSERT INTO picturebests (pictureID, userID, projectID) VALUES (?, ?, ?)";

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

public function getProjectCount($projectID):int{
    $sqlQuery = "SELECT COUNT(projectID) AS projectCount FROM projects WHERE projectID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $projectID);
    $statement->execute();

    $result = $statement->get_result();

    $projectCount = $result->fetch_assoc()["projectCount"];

    $statement->close();

    return $projectCount;
}

public function projectExists($projectID):bool{
    $projectCount = $this->getProjectCount($projectID);

    if($projectCount >= 1){
        return true;
    }else{
        return false;
    }
}

public function getProjectName($projectID):String{
    $sqlQuery = "SELECT projectName AS projectName FROM projects WHERE projectID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $projectID);
    $statement->execute();

    $result = $statement->get_result();

    $projectName = $result->fetch_assoc()["projectName"];

    $statement->close();

    return $projectName;
}

public function getProjectNames(): array
{
    $sqlQuery = "SELECT projectName AS projectNames FROM projects";

    $result = $this->dbKeyObject->query($sqlQuery);

    $rows = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($rows, $row);
    }
    return $rows;
}

public function getProjectIDs(): array
{
    $sqlQuery = "SELECT projectID AS projectIDs FROM projects";

    $result = $this->dbKeyObject->query($sqlQuery);

    $rows = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($rows, $row);
    }
    return $rows;
}

public function getPictureIDs($projectID): array
{
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

public function getPictureAuthorIDs($projectID): array
{
    $sqlQuery = "SELECT userID AS authIDs FROM pictures WHERE projectID = ?";

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

public function getPictureFileName($picID){
    $sqlQuery = "SELECT picFileName AS picFileName FROM pictures WHERE picID = ?";

    $statement = $this->dbKeyObject->prepare($sqlQuery);
    $statement->bind_param("i", $picID);
    $statement->execute();

    $result = $statement->get_result();

    $picFileName = $result->fetch_assoc()["picFileName"];

    $statement->close();

    return $picFileName;
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

public function hasUploaded($userID,$projectID): bool
{
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

public function getUserAccountLevel($userID){
  $sqlQuery = "SELECT userAccountLevel FROM user WHERE userID = ?";

  $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
  $sqlStatement->bind_param("i", $userID);

  $sqlStatement->execute();

  $result = $sqlStatement->get_result();

  $userAccountLevel = $result->fetch_assoc()["userAccountLevel"];

  $sqlStatement->close();

  return $userAccountLevel;
}

public function hasAcceptedTerms($userID): bool
{
    $sqlQuery = "SELECT acceptedTerms FROM user WHERE userID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $userID);

    $sqlStatement->execute();

    $result = $sqlStatement->get_result();

    $acceptedTerms = $result->fetch_assoc()["acceptedTerms"];

    $sqlStatement->close();

    if ($acceptedTerms <= 0){
        return false;
    }else{
        return true;
    }
}

public function acceptTerms($userID){
    $sqlQuery = "UPDATE user SET acceptedTerms = 1 WHERE userID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $userID);
    $sqlStatement->execute();

    $sqlStatement->close();
}

public function removeLike($userID,$picID){
    $sqlQuery = "DELETE FROM picturelikes WHERE userID = ? AND pictureID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("ii", $userID, $picID);
    $sqlStatement->execute();

    $sqlStatement->close();
}

public function removeBest($userID, $picID){
    $sqlQuery = "DELETE FROM picturebests WHERE userID = ? AND pictureID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("ii", $userID, $picID);
    $sqlStatement->execute();

    $sqlStatement->close();
}

public function getBestedID($userID, $projectID){
    $sqlQuery = "SELECT pictureID AS pictureID FROM picturebests WHERE userID = ? AND projectID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("ii", $userID, $projectID);

    $sqlStatement->execute();

    $result = $sqlStatement->get_result();

    $picID = $result->fetch_assoc()["pictureID"];

    $sqlStatement->close();

    return $picID;
}

public function deletePicture($picID){
    $sqlQuery = "SELECT picFileName, projectID FROM pictures WHERE picID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $picID);
    $sqlStatement->execute();
    $result = $sqlStatement->get_result();

    $row = $result->fetch_assoc();

    $projectName = $this->getProjectName(intval($row['projectID']));
    $fileName = $row['picFileName'];

    $sqlStatement->close();

    $file = "../uploads/".$projectName."/".$fileName;

    if(file_exists(realpath($file))) {
        unlink(realpath($file));
    }

    $sqlQuery = "DELETE FROM picturelikes WHERE pictureID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $picID);
    $sqlStatement->execute();

    $sqlStatement->close();

    $sqlQuery = "DELETE FROM picturebests WHERE pictureID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $picID);
    $sqlStatement->execute();

    $sqlStatement->close();

    $sqlQuery = "DELETE FROM pictures WHERE picID = ?";

    $sqlStatement = $this->dbKeyObject->prepare($sqlQuery);
    $sqlStatement->bind_param("i", $picID);
    $sqlStatement->execute();

    $sqlStatement->close();
}

}
?>
