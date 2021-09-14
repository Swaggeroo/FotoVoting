const projectLinks = document.getElementsByClassName("projectLink");

const editButtons = document.getElementsByClassName("editButton");
const deleteButtons = document.getElementsByClassName("deleteButton");
const projectNames = document.getElementsByClassName("projectNames");

//Edit form
const closeEditProjectWindowButton = document.getElementById("closeEditProjectWindowButton");
const newProjectNameEditInput = document.getElementById("newProjectNameEditInput");
const projectIdEditInput = document.getElementById("projectIdEditInput");
const changeProjectNameButton = document.getElementById("changeProjectNameButton");

const editProjectDialog = document.getElementById("editProjectDialog");
const editProjectBlackBackground = document.getElementById("editProjectBlackBackground");
//-------------------------------------

function addBackTrackToLinks(){

  let params = new URLSearchParams();

  params.set("back", window.location.href);

  for(var i = 0; i < projectLinks.length; i++){
     projectLinks[i].href += "&" + params.toString();
  }

}

window.addEventListener("load", addBackTrackToLinks);

function deleteProject(e){
    e.preventDefault();

    var projectID = this.getAttribute("data-id");

    var projectName = projectNames[parseInt(his.getAttribute("data-index"))].textContent;

    let answer = confirm("Willst du wirklich das Projekt '"+ projectName +"' wirklich löschen?");
    if(answer){
        console.log("Delete "+ projectID);
        let oReq = new XMLHttpRequest();
        let parms = "projectID="+ projectID;
        oReq.open("POST","../php/deleteProjectManager.php");
        oReq.addEventListener('load',function(){
            window.location.reload();
        })
        oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        oReq.send(parms);
    }
}

function editProject(){
    //Get data
     var projectID = parseInt(projectIdEditInput.value);
     var newName = newProjectNameEditInput.value;

    console.log("Edit "+ projectID +" -> "+ newName);
    let oReq = new XMLHttpRequest();
    let parms = "projectID="+ projectID +"&newName=" + newName;
    oReq.open("POST","../php/editProjectManager.php");
    oReq.addEventListener('load',function(){
        window.location.reload();
    })
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}

function openEditForm(e){
   e.preventDefault();

   //Get data
   var projectID = parseInt(this.getAttribute("data-id"));
   var projectName = projectNames[parseInt(this.getAttribute("data-index"))].textContent;

   //set data in edit form
   projectIdEditInput.value = projectID;
   newProjectNameEditInput.value = projectName;

   //Show window
   showEditProjectWindow();
}

function showEditProjectWindow(){
  //Set display to normal
  editProjectDialog.style.display = "inline";
  editProjectBlackBackground.style.display = "inline";
  //Set opacity
  setTimeout(function (){
    editProjectBlackBackground.style.opacity = "1";
    editProjectDialog.style.opacity = "1";
  },10);
}

function hideEditProjectWindow(){
  editProjectDialog.style.opacity = "0";
  editProjectBlackBackground.style.opacity = "0";

  setTimeout(function () {
    editProjectDialog.style.display = "none";
    editProjectBlackBackground.style.display = "none";
  }, 200);
}

//Event listener for UI
closeEditProjectWindowButton.addEventListener("click", hideEditProjectWindow);
changeProjectNameButton.addEventListener("click", editProject);

for(let i = 0; i < editButtons.length; i++){
   editButtons[i].addEventListener("click", openEditForm);
   deleteButtons[i].addEventListener("click", deleteProject);

   //Set index
   editButtons[i].setAttribute("data-index", i);
   deleteButtons[i].setAttribute("data-index", i);
}
//--------------------


let deferredPrompt;
const addBtn = document.querySelector('.add-button');
addBtn.style.display = 'none';
window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    // Update UI to notify the user they can add to home screen
    addBtn.style.display = 'block';

    addBtn.addEventListener('click', (e) => {
        // hide our user interface that shows our A2HS button
        addBtn.style.display = 'none';
        // Show the prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the A2HS prompt');
            } else {
                console.log('User dismissed the A2HS prompt');
            }
            deferredPrompt = null;
        });
    });
});
