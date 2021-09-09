<?php
    //Define str_contains function if not exist
    if (!function_exists('str_contains')) {

    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}

    $backtrackPage = "";

    if(isset($_GET["back"])){
      $backtrackPage = trim(stripslashes(htmlspecialchars($_GET["back"])));
      //Check if link is only relative
      if(str_contains($backtrackPage, "https://")){
        $backtrackPage = "";
      }

    }

?>

<div id="userNavigationBar">

<div class="leftNavigationBarFlex">
  <?php
     //load going back button only if there backtrack link is given
     if(strlen($backtrackPage) > 0){
       echo "<div id='userGoBackButton' data-value='".$backtrackPage."'>
         &#10132;
       </div>";
     }

   ?>

</div>


  <div class="rightNavigationBarFlex">
    <?php
      //only show addButton if User has Admin level
      if($_SESSION["userAccountLevel"] >= 2){
        echo "<div id='addButton'>
          Hinzufügen +
        </div>";
      }
     ?>

   <div id="logOutButton">
    Ausloggen
   </div>
 </div>

</div>

<script src="../scripts/userNavigationBar.js"></script>
