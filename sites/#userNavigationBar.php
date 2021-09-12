<?php

    $backtrackPage = "";
    if(isset($_GET["back"])){
      $backtrackPage = trim(stripslashes(htmlspecialchars($_GET["back"])));
       //Check if backtrackPage is valid
       $parsedUrl = parse_url($backtrackPage);
       if(isset($parsedUrl["host"])){

        if($parsedUrl["host"] != $_SERVER['HTTP_HOST']){
          $backtrackPage = "";
       }
     }

    }

?>


<?php
//only load menu if User has Admin level
if($_SESSION["userAccountLevel"] >= 2){
 echo "
 <!--Create Project Window--->
 <div id='blackBackgroundCreateProjectWindow'></div>

 <div id='createProjectWindow'>
   <div id='closeCreateProjectWindow'>
    <span id='closeCreateProjectWindowButton'>&#10006;</span>
   </div>

   Projekt hinzufügen:
   <form action='../php/createProject.php' method='POST'/>
     <input type='text' name='projectName' placeholder='Projektname' required/>
     <br>
     <br>
     <input type='submit' id='addProjectButton' value='Hinzufügen'/>
   </form>
 </div>
 ";
}
 ?>


<!------------------------------------------->
<!--User navigation Bar ----->
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

   <div id="logOutButton">
    Ausloggen
   </div>
 </div>

</div>
<!----------------------------------------------------------------------------------->

<script src="../scripts/userNavigationBar.js"></script>
