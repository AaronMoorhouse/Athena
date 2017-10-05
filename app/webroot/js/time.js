/**
 * Javascript script for live clock.
 *
 */

//Script entry point
addLoadEvent(xClock);

/**
 *
 * Get current time and display on screen.
 *
 */
function xClock() {
	// Get current system time
	xC = new Date;

	//format and pad time display
	if(xC.getHours() > 12) {
		xV = (xC.getHours() - 12) + ":" + vClock(xC.getMinutes()) + ":" + vClock(xC.getSeconds()) + " PM";
	}
	else if(xC.getHours() == 12) {
		xV = "12" + ":" + vClock(xC.getMinutes()) + ":" + vClock(xC.getSeconds()) + " PM";
	}
	else {
		xV = vClock(xC.getHours()) + ":" + vClock(xC.getMinutes()) + ":" + vClock(xC.getSeconds()) + " AM";
	}

	//Display time in div
	document.getElementById("time").innerHTML = xV;

	//Recursion with 1 second delay
	setTimeout("xClock()", 1000);
}

/**
 *
 * Pad value with leading 0.
 *
 * @param   integer  v Value for minutes or seconds to pad.
 * @return  Value with leading 0 if it is a single digit.
 *
 */
function vClock(v) {
   return (v > 9) ? v : "0" + v;
}


function addLoadEvent(func) {
	var oldonload = window.onload;

	if (typeof window.onload != 'function') {
		window.onload = func;
	} 
	else {
	  window.onload = function() {
		if (oldonload) {
			oldonload();
		}
		
		func();
		}
	}
}