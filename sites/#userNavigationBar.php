<?php

    $backtrackPage = "";
    if(isset($_GET["back"])){
      $backtrackPage = trim(stripslashes(htmlspecialchars($_GET["back"])));
       //Check if backtrackPage is valid
       $parsedUrl = parse_url($backtrackPage);
       if(isset($parsedUrl["host"])){

        if($parsedUrl["host"] != "mhsl.eu"){
          $backtrackPage = "";
       }
     }

    }

?>

<!--Create Project Window-->
<div id='blackBackgroundCreateProjectWindow'></div>

<?php
//only load menu if User has Admin level
if($_SESSION["userAccountLevel"] >= 2){
 echo "

 <div id='createProjectWindow'>
   <div id='closeCreateProjectWindow'>
    <span id='closeCreateProjectWindowButton'>&#10006;</span>
   </div>

   Projekt hinzufügen:
   <form id='createProjectForm' action='../php/createProject.php' method='POST'>
     <input type='text' name='projectName' placeholder='Projektname' required/>
     <br>
     <br>
     <input type='submit' id='addProjectButton' value='Hinzufügen'/>
   </form>
 </div>
 ";
}
 ?>

<!--Change username Form-->
<div id='changeUserPasswordWindow'>
  <div id='closeChangePasswordWindow'>
   <span id='closeChangeUserPasswordWindowButton'>&#10006;</span>
  </div>

  Passwort ändern:
  <form id='changeUserPasswordForm' action='../php/userChangePassword.php' method='POST'>
    <input type="password" name="oldPassword" placeholder="Altes Passwort" required/>
    <br>
    <br>
    <input id="newPasswordInput" type="password" name="newPassword" placeholder="Neues Passwort" required/>
    <br>
    <br>
    <input id="newPasswordConfirmInput" type="password" name="newPasswordConfirm" placeholder="Neues Passwort bestätigen" required/>
    <br>
    <br>
    <input type='button' id='changePasswordFormButton' value='Passwort ändern'/>
  </form>
</div>

<!--###############################################################-->
<!--User navigation Bar -->
<div id="userNavigationBar">

<div class="leftNavigationBarFlex">
  <?php
     //load going back button only if there backtrack link is given
     if(strlen($backtrackPage) > 0){
       echo "<div id='userGoBackButton' data-link='".$backtrackPage."'>
         &#10132;
       </div>";
     }

   ?>

</div>


  <div class="rightNavigationBarFlex">
    <?php
      //only show addButton if User has Admin level
      if($_SESSION["userAccountLevel"] >= 2){
        echo "
        <div id='navEdit'>
        <div id='NavBarEditButton'>
          Bearbeiten &#x270E;
        </div>
          <div id='NavBarEditDropDown'>
            <p id='goToUserManagementButton'>Benutzerverwaltung</p>
            <p id='openCreateProjectWindowButton'>Projekt erstellen</p>
        </div>
        </div>";
      }
     ?>

   <div id="accountSettings">
     <div id="currentUsernameButton">
     <?php echo $_SESSION["username"]." &#x2BC6;" ?>
    </div>
     <div id='accountSettingsDropDown'>
       <p id='changePasswordButton'>Passwort ändern</p>
       <p id='logOutButton'>Ausloggen</p>
   </div>
 </div>
</div>

</div>
<!--###############################################################-->

<script src="../scripts/userNavigationBar.js"></script>
