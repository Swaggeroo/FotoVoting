let logOutButton = document.getElementById("logOutButton");

function logOut(){
 window.location.replace("../logout.php");
}

//Set logoutbutton listener
logOutButton.addEventListener("click", logOut);
