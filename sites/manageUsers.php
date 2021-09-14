<?php
  require "../php/checkPermission.php";

  require "../php/onlyAdminLevel.php";

   $backtrack = "";
  //Save get parameter if valid
  if(isset($_GET["back"])){
    $backtrack = trim(stripslashes(htmlspecialchars($_GET["back"])));

    //Check if backtrackPage is valid
    $parsedUrl = parse_url($backtrack);
    if(isset($parsedUrl["host"])){

     if($parsedUrl["host"] != $_SERVER['HTTP_HOST']){
       $backtrack = "";
    }
  }
}

 ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--basic Style-->
    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="../CSS/manageUser.css">

    <script src="../scripts/manageUser.js" defer></script>

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
    <link rel="manifest" href="../media/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

  <?php
     include "#userNavigationBar.php";
   ?>

<div id="editUserBlackBackground">
</div>

   <form id="deleteUserForm" action="../php/deleteUser.php<?php if(strlen($backtrack) > 0){ echo "?back=".$backtrack;}?>" method="POST">
       <input type="hidden" value="" name="userID" id="delteUserIDInput" required/>
       <input type="hidden" value="" name="username" id="deleteUsernameInput" required/>
   </form>

   <div id="editUserDialog">
      <!--Edit username Dialog-->
      <div id='closeEditUserWindow'>
       <span id='closeEditUserWindowButton'>&#10006;</span>
      </div>

      Nutzer bearbeiten:
      <br>
      <br>
      <form action="../php/adminEditUser.php<?php if(strlen($backtrack) > 0){ echo "?back=".$backtrack;}?>" method="post">
         <input id="newUsernameEditInput" type="text" value="" name="newUsername" placeholder="Neuer Benutzername" required/>
         <input type="submit" value="Benutzname ändern"/>
         <input type="hidden" name="operation" value="username" required/>
         <input class="userIDInput" type="hidden" name="userID" value="" required>
      </form>
      <br>
      <br>
      <form action="../php/adminEditUser.php<?php if(strlen($backtrack) > 0){ echo "?back=".$backtrack;}?>" method="post">
        <input type="password" name="newPassword" value="" placeholder="Neues Passwort" required/>
        <input type="hidden" name="operation" value="password" required/>
        <input class="userIDInput" type="hidden" name="userID" value="" required>
        <input type="submit" value="Passwort setzen"/>
      </form>
      <br>
      <br>
      <form action="../php/adminEditUser.php<?php if(strlen($backtrack) > 0){ echo "?back=".$backtrack;}?>" method="post">
      UserAccountLevel:  <select id="userAccountlevelEditInput" name="newUserAccountLevel" required>
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <input type="hidden" name="operation" value="userAccountLevel" required/>
        <input type="hidden" class="userIDInput" name="userID" value="" required>
       <input type="submit" value="AccountLevel setzen">
      </form>
      <br>
      <br>
   </div>

 <form id="addUserForm" action="../php/addUser.php<?php if(strlen($backtrack) > 0){ echo "?back=".$backtrack;}?>" method="POST">
   <input type="text" name="userName" placeholder="Benutzername" required/>
   <input type="password" name="userPassword" placeholder="Passwort" required/>
    UserAccountLevel: <select name="userAccountLevel">
      <option value="1">1</option>
      <option value="2">2</option>
    </select>
   <input type="submit" value="+" />
 </form>

  <div align="center" style="width: 100%;">
    <table id="userTable">
      <tr>
        <th>Benutzername</th>
        <th>AccountLevel</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      <?php
          //Load all user from database
          require "../php/dbConnection.php";

          $db = new db();

          $userData = $db->getAllUsers();

          for($i = 0; $i < count($userData); $i++){
            echo "
            <tr>
              <td class='username'>".$userData[$i][0]."</td>
              <td class='userAccountLevel'>
               ".$userData[$i][2]."
              </td>
              <td>
               <a class='editUser' data-id='".$userData[$i][1]."'>&#x270E;
                </a></td>
              <td>
              <a class='deleteUser' data-id='".$userData[$i][1]."'>&#10006;
              </a>
              </td>
            </tr>
            ";
          }
       ?>
    </table>
  </div>

</body>

</html>
