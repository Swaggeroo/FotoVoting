const logOutButton = document.getElementById("logOutButton");

const goBackButton = document.getElementById("userGoBackButton");

//Dropdown vars
const navigationEditButton = document.getElementById("NavBarEditButton");
const navigationEditDropdown = document.getElementById("NavBarEditDropDown");
var dropDownTimer;

//DropDown Buttons
const goToUserManagementButton = document.getElementById("goToUserManagementButton");

function logOut(){
 window.location.replace("../logout.php");
}

function showEditDropDownMenuFromEditButton(){
 navigationEditDropdown.style.display = "inline";

//Event listener for leaving
 navigationEditButton.addEventListener("mouseleave", function (){
  startHideDropDownMenuCountdownFromElement(navigationEditDropdown);
 });
}

function hideDropDownMenuFromEditButton(){
   startHideDropDownMenuCountdownFromElement(navigationEditButton);
}

function startHideDropDownMenuCountdownFromElement(element){
  //Clear old tiemr
  clearTimeout(dropDownTimer);
  //Set eventlisnter for disabling timer
  element.addEventListener("mouseover", disableDropDownTimer);
  //set Timeout for disabling dropmenu
  dropDownTimer = setTimeout(hideEditDropDownMenu, 200);
}

function disableDropDownTimer(){
  clearTimeout(dropDownTimer);
}

function hideEditDropDownMenu(){
 navigationEditDropdown.style.display = "none";
}

function goBackToLastPage(){
  window.location.replace(goBackButton.getAttribute("data-link"));
}

function goToUserManagement(){
   window.location.href = "manageUsers.php?back=" + window.location.href;
}

//Set logoutbutton listener
logOutButton.addEventListener("click", logOut);

//Set eventlistener for going back (only if exists)
if(goBackButton != null){
  goBackButton.addEventListener("click", goBackToLastPage);
}

//Only activate Navigation Listeners if object exists
if(navigationEditButton != null){
//Set mouseover listener for navigationEditButton
navigationEditButton.addEventListener("mouseover", showEditDropDownMenuFromEditButton);
//Set mouseleave Event for navigationEdit container
navigationEditDropdown.addEventListener("mouseleave", hideDropDownMenuFromEditButton);
//Set eventlistener for Usermangament button
goToUserManagementButton.addEventListener("click", goToUserManagement);
}
