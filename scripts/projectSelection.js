const projectLinks = document.getElementsByClassName("projectLink");

function addBackTrackToLinks(){

  let params = new URLSearchParams();

  params.set("back", window.location.href);

  for(var i = 0; i < projectLinks.length; i++){
     projectLinks[i].href += "&" + params.toString();
  }

}

window.addEventListener("load", addBackTrackToLinks);

function deleteProject(projectID){
    let answer = confirm("Willst du wirklich das Project löschen?")
    if(answer){
        console.log("Delete "+projectID);
        let oReq = new XMLHttpRequest();
        let parms = "projectID="+projectID;
        oReq.open("POST","../php/deleteProjectManager.php");
        oReq.addEventListener('load',function(){
            window.location.reload();
        })
        oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        oReq.send(parms);
    }
}

function editProject(projectID,newName){
    console.log("Edit "+projectID+" -> "+newName);
    let oReq = new XMLHttpRequest();
    let parms = "projectID="+projectID+"&newName="+newName;
    oReq.open("POST","../php/editProjectManager.php");
    oReq.addEventListener('load',function(){
        window.location.reload();
    })
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}


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
