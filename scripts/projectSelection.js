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
