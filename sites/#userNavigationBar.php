<?php
    $backtrackPage = "";

    if(isset($_GET["back"])){
      $backtrackPage = trim(stripslashes(htmlspecialchars($_GET["back"])));
    }

?>

<div id="userNavigationBar">

<div class="leftNavigationBarFlex">
   <div id="userGoBackButton">
     &#10132;
   </div>
</div>


  <div class="rightNavigationBarFlex">
   <div id="addButton">
     Hinzufügen +
   </div>

   <div id="logOutButton">
    Ausloggen
   </div>
 </div>

</div>

<script src="../scripts/userNavigationBar.js"></script>
