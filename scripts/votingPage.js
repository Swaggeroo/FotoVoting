function best(picID){
    console.log(picID);
    console.log("Test");
    alert(picID);
}

function like(picID){
    let oReq = new XMLHttpRequest();
    let parms = "picID="+picID;
    oReq.addEventListener("load",function() {
        document.getElementById("like"+picID).style.backgroundColor = 'green';
    })
    oReq.open("POST","../php/likeManager.php");
    oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    oReq.send(parms);
}