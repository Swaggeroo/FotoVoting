const addPictureButton = document.getElementById("addPictureButton");

function best(picID, projectID){
    console.log(picID, projectID);
    let element = document.getElementById("best"+picID);
    let content = element.textContent;
    if(!element.classList.contains("bested")){
        let bests = document.getElementsByClassName("bested")
        if (bests.length <= 0){
            element.classList.add("bested");
            element.textContent = generateNewText(content,1);
        }else{
            alert("Du kannst nur ein Bild besten.");
        }
    }else {
        element.classList.remove("bested");
        element.textContent = generateNewText(content,-1);
    }
    let oReq = new XMLHttpRequest();
    let parms = "picID="+picID+"&projectID="+projectID;
    oReq.open("POST","../php/bestManager.php");
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}

function like(picID){
    console.log(picID);
    let element = document.getElementById("like"+picID);
    let content = element.textContent;
    if (!element.classList.contains("liked")){
        element.classList.add("liked");
        element.textContent = generateNewText(content,1);
    }else{
        element.classList.remove("liked");
        element.textContent = generateNewText(content,-1);
    }
    let oReq = new XMLHttpRequest();
    let parms = "picID="+picID;
    oReq.open("POST","../php/likeManager.php");
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}

function generateNewText(content, addNumber){
    let number = parseInt(content.substring(content.indexOf("(")+1,content.indexOf(")")));
    const contentBefore = content.substring(0,content.indexOf("(")+1);
    const contentAfter = content.substring(content.indexOf(")"));
    return contentBefore + (number + addNumber) + contentAfter;
}

function deletePic (picID){
    let answer = confirm("Willst du wirklich das Bild löschen?")
    if(answer){
        console.log("Delete "+picID);
        let oReq = new XMLHttpRequest();
        let parms = "picID="+picID;
        oReq.open("POST","../php/deleteManager.php");
        oReq.addEventListener('load',function(){
            window.location.reload();
        })
        oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        oReq.send(parms);
    }
}

function addBackTrackLinkToAddButton(){
  let params = new URLSearchParams();

  params.set("back", window.location.href);

  addPictureButton.href += "&" + params.toString();
}

function resizeAddButton(){
      var breite = getComputedStyle(addPictureButton).width;

      addPictureButton.style.height = breite;

      addPictureButton.style.fontSize = parseFloat(breite)*0.87 + "px";
}


window.addEventListener("load", addBackTrackLinkToAddButton);
window.addEventListener("resize", resizeAddButton);
resizeAddButton();
