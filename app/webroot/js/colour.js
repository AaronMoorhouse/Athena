function getLightness(colour) {
	//var colour = rgbToHex(colour);
	// var r = parseInt(colour.substring(0, 2), 16);
	// var g = parseInt(colour.substring(2, 4), 16);
	// var b = parseInt(colour.substring(4, 6), 16);
	
	
	// var lightness = Math.sqrt((0.241 * Math.pow(r, 2)) + (0.691 * Math.pow(g, 2)) + (0.068 * Math.pow(b, 2)));
	
	// console.log(r);
	// return lightness;
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return componentToHex(r) + componentToHex(g) + componentToHex(b);
}