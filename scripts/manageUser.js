const deleteUserForm = document.getElementById("deleteUserForm");
const deleteUserIDInput = document.getElementById("delteUserIDInput");

//Get all delete Buttons
var deleteButtons = document.getElementsByClassName("deleteUser");
//Get all Usernames
var usernames = document.getElementsByClassName("username");

function deleteUser(){
  if(!confirm("Den Benutzer "+ usernames[parseInt(this.getAttribute("data-index"))].textContent +" wirklich löschen?")){
    return;
  }

  const userID = this.getAttribute("data-id");

  //Set userId in delte Form
  deleteUserIDInput.value = userID;
  //Send form
  deleteUserForm.submit();
}


//Add all Eventlisteners for delete
for(var i = 0; i < deleteButtons.length; i++){
  //save index for later
  deleteButtons[i].setAttribute("data-index", i);
  //-------
  deleteButtons[i].addEventListener("click", deleteUser);
}
