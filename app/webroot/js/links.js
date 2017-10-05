function setActiveLink(link) {
	var links = document.getElementsByTagName("A");
	var colour = window.getComputedStyle(document.getElementById("top")).backgroundColor;

	for(var i = 0; i < links.length; i++) {
		if(links[i].innerHTML == link) {		
			if(getLightness(colour) > 180) {
				//console.log("here 888888");
				links[i].style.color = "#888888";
			}
			else {
				//console.log("here cccccc");
				links[i].style.color = "#CCCCCC";
			}
			
			links[i].style.textDecoration = "underline";
		}
	}
}