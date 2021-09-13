const deleteUserForm = document.getElementById("deleteUserForm");
const deleteUserIDInput = document.getElementById("delteUserIDInput");
const deleteUsernameInput = document.getElementById("deleteUsernameInput");

//Get all edit buttons
const editButtons = document.getElementsByClassName("editUser");
//Edit dialog vars
const editUserDialog = document.getElementById("editUserDialog");
const editUserDialogBackground = document.getElementById("editUserBlackBackground");
const closeEditUserDialogButton = document.getElementById("closeEditUserWindowButton");
//Get all delete Buttons
const deleteButtons = document.getElementsByClassName("deleteUser");
//Get all Usernames
const usernames = document.getElementsByClassName("username");

function deleteUser(){
  var username = usernames[parseInt(this.getAttribute("data-index"))];

  if(!confirm("Den Benutzer "+ username +" wirklich löschen?")){
    return;
  }

  const userID = this.getAttribute("data-id");

  //Set username in form
  deleteUsernameInput.value = username;
  //Set userId in delte Form
  deleteUserIDInput.value = userID;
  //Send form
  deleteUserForm.submit();
}

function openEditUser(){
  var username = usernames[parseInt(this.getAttribute("data-index"))];

  showEditUserWindow();
}

function showEditUserWindow(){
  //Set display to normal
  editUserDialog.style.display = "inline";
  editUserDialogBackground.style.display = "inline";
  //Set opacity
  setTimeout(function (){
    editUserDialogBackground.style.opacity = "1";
    editUserDialog.style.opacity = "1";
  },10);
}

function hideEditUserWindow(){
  editUserDialog.style.opacity = "0";
  editUserDialogBackground.style.opacity = "0";

  setTimeout(function () {
    editUserDialog.style.display = "none";
    editUserDialogBackground.style.display = "none";
  }, 200);
}

//Add all Eventlisteners for delete and edit buttons
for(let i = 0; i < deleteButtons.length; i++){
  //save index for later
  deleteButtons[i].setAttribute("data-index", i);
  editButtons[i].setAttribute("data-index", i);
  //-------
  deleteButtons[i].addEventListener("click", deleteUser);
  editButtons[i].addEventListener("click", openEditUser);
}

closeEditUserWindowButton.addEventListener("click", hideEditUserWindow);
