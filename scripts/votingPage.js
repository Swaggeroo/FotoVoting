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