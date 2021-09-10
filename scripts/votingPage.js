function best(picID, projectID){
    console.log(picID, projectID);
    let oReq = new XMLHttpRequest();
    let parms = "picID="+picID+"&projectID="+projectID;
    oReq.addEventListener("load",function() {
        let element = document.getElementById("best"+picID);
        if(!element.classList.contains("bested")){
            element.classList.add("bested");
        }else {
            element.classList.remove("bested");
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
        let element = document.getElementById("like"+picID);
        if (!element.classList.contains("liked")){
            element.classList.add("liked");
        }else{
            element.classList.remove("liked");
        }
    })
    oReq.open("POST","../php/likeManager.php");
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}