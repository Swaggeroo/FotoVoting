function best(picID, projectID){
    console.log(picID, projectID);
    let oReq = new XMLHttpRequest();
    let parms = "picID="+picID+"&projectID="+projectID;
    oReq.addEventListener("load",function() {
        document.getElementById("best"+picID).classList.add("bested");
    })
    oReq.open("POST","../php/bestManager.php");
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}

function like(picID){
    console.log(picID);
    let oReq = new XMLHttpRequest();
    let parms = "picID="+picID;
    oReq.addEventListener("load",function() {
        document.getElementById("like"+picID).classList.add("liked");
    })
    oReq.open("POST","../php/likeManager.php");
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}