function best(picID, projectID){
    console.log(picID, projectID);
    let oReq = new XMLHttpRequest();
    let parms = "picID="+picID+"&projectID="+projectID;
    oReq.addEventListener("load",function() {
        if(!document.getElementById("best"+picID).classList.contains("bested")){
            document.getElementById("best"+picID).classList.add("bested");
        }else {
            document.getElementById("best"+picID).classList.remove("bested");
        }
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
        if (!document.getElementById("like"+picID).classList.contains("liked")){
            document.getElementById("like"+picID).classList.add("liked");
        }else{
            document.getElementById("like"+picID).classList.remove("liked");
        }
    })
    oReq.open("POST","../php/likeManager.php");
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}