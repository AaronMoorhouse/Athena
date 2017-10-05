<div id="content">
	<h1><a href="https://goo.gl/Tk91z8" target="_blank" style="text-decoration: none; color: inherit; cursor: default;">404</a> - OOPS!</h1>
	<p>I can't seem to find the page you are looking for.</p>
	<p>Have you tried turning it off and on again?</p>
	<p><strong>Current state:</strong> <span id="state" style="color: green">On</span></p>
	<button class="button" style="margin: 0 20px 10px 0" <?php echo 'onclick="turnOff(\''.$_SESSION['last'].'\')"'; ?>>Off</button>
	<button id="on" class="button">On</button>
</div>
<script>
	var onButton = document.getElementById("on");
	var state = document.getElementById("state");
	var off = false;
	
	function turnOff(link) {
		if(!off) {
			off = true;
			onButton.onclick = function() { window.location = link };
			
			state.innerHTML = "Off";
			state.style.color = "red";
		}
	}
</script>