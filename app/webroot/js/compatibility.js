function showColourInputField() {
	document.getElementById("colour_picker").style.display = "none";
	document.getElementById("colour_picker_ie").style.display = "block";
	document.getElementById("colour_picker_ie").name = "colour";
	document.getElementById("note").style.display = "block";
	
	var labels = document.getElementsByTagName("LABEL");
	
	for(var i = 0; i < labels.length; i++) {
		if(labels[i].htmlFor == "colour_picker") {
			labels[i].style.display = "none";
		}
		else if(labels[i].htmlFor == "colour_picker_ie") {
			labels[i].style.display = "block";
		}
	}
}