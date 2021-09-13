const projectLinks = document.getElementsByClassName("projectLink");

function addBackTrackToLinks(){

  let params = new URLSearchParams();

  params.set("back", window.location.href);

  for(var i = 0; i < projectLinks.length; i++){
     projectLinks[i].href += "&" + params.toString();
  }

}

window.addEventListener("load", addBackTrackToLinks);
