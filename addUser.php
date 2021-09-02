<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title>Add User</title>
  </head>
  <body>
      <form action="addUser.php" method="POST">
          <input type="text" name="username" placeholder="username" required/>
          <br>
          <br>
          <input type="text" name="password" placeholder="password" required/>
          <br>
          <br>
          <input type="submit" value="add"/>
      </form>

      <?php

       if($_SERVER["REQUEST_METHOD"] == "POST"){

         require "php/dbConnection.php";

        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $dbObject = new db();

        $dbObject->addUser($username, $passwordHash);

        }
      ?>
  </body>
</html>
