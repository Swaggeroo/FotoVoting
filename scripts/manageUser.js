const deleteUserForm = document.getElementById("deleteUserForm");
const deleteUserIDInput = document.getElementById("delteUserIDInput");
const deleteUsernameInput = document.getElementById("deleteUsernameInput");

//Get all delete Buttons
let deleteButtons = document.getElementsByClassName("deleteUser");
//Get all Usernames
let usernames = document.getElementsByClassName("username");

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


//Add all Eventlisteners for delete
for(let i = 0; i < deleteButtons.length; i++){
  //save index for later
  deleteButtons[i].setAttribute("data-index", i);
  //-------
  deleteButtons[i].addEventListener("click", deleteUser);
}
