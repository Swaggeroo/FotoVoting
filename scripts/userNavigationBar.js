const logOutButton = document.getElementById("logOutButton");

const goBackButton = document.getElementById("userGoBackButton");

//Dropdown vars
const navigationEditButton = document.getElementById("NavBarEditButton");
const navigationEditDropdown = document.getElementById("NavBarEditDropDown");
var dropDownTimer;

//Create project Buttons
const closeCreateProjectWindowButton = document.getElementById("closeCreateProjectWindowButton");
const blackBackgroundCreateProjectWindow = document.getElementById("blackBackgroundCreateProjectWindow");
const createProjectWindow = document.getElementById("createProjectWindow");
const openCreateProjectWindowButton = document.getElementById("openCreateProjectWindowButton");
const createProjectForm = document.getElementById("createProjectForm");

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
  window.location.href = goBackButton.getAttribute("data-link");
}

function goToUserManagement(){
   let params = new URLSearchParams();

   params.set("back", window.location.href);

   window.location.href = "manageUsers.php?" + params.toString();
}

function closeCreateProjectWindow(){
  blackBackgroundCreateProjectWindow.style.opacity = "0";
  createProjectWindow.style.opacity = "0";

  setTimeout(function () {
    blackBackgroundCreateProjectWindow.style.display = "none";
    createProjectWindow.style.display = "none";
  }, 200);
 }

 function openCreateProjectWindow(){
   //Set display to normal
   blackBackgroundCreateProjectWindow.style.display = "inline";
   createProjectWindow.style.display = "inline";
   //Set opacity
   setTimeout(function (){
     blackBackgroundCreateProjectWindow.style.opacity = "1";
     createProjectWindow.style.opacity = "1";
   },10);

 }

 function setBackTrackToCreateProject(){
   let params = new URLSearchParams();

   params.set("back", window.location.href);

   createProjectForm.action += "?" + params.toString();
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

//Set eventlisteners for Create Project
if(createProjectWindow != null){
closeCreateProjectWindowButton.addEventListener("click", closeCreateProjectWindow);
openCreateProjectWindowButton.addEventListener("click", openCreateProjectWindow);
window.addEventListener("load", setBackTrackToCreateProject);
}
