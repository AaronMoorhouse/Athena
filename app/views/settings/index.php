<noscript>
	<div class="msg-red">
		<p>Some elements on this page require JavaScript</p>
	</div>
</noscript>
<div id="content">
	<ul class="breadcrumbs">
		<li><a href="./">Home</a></li>
		<li>Settings</li>
	</ul>
	<h1>Account Settings</h1>
	<p>Here you can update your email address, change your password and alter the website's colour scheme.</p>
	<form method="post" action="./settings/updateSettings">
		<h2>Email Address</h2>
		<label class="formlabel" for="email">Email:</label>
		<input class="formfield largefield" name="email" type="email" <?php echo "value=\"".$_SESSION['user']['email']."\""; ?> required/>
		<h2>Change Password</h2>
		<p>If you need to change your current password, you can do so <a href="./settings/password">here</a>.</p>
		<h2>Theme Colour</h2>
		<p id="colour_p">You can customise the colour scheme by selecting one of the preset colours or by using the colour picker below:</p>
		<label for="colour_picker">Colour:</label>
		<input id="colour_picker" name="colour" type="color" <?php echo "value=\"".$colour."\""; ?> required/>
		<label for="colour_picker_ie">Colour (Hex):</label>
		<input id="colour_picker_ie" class="formfield" type="text" <?php echo "value=\"".$_SESSION['user']['colour']."\""; ?> required/>
		<button type="button" onclick="return showPresets()">Show Preset Colours</button><br/><br/>
		<button type="button" onclick="selectColour('#337399')">Reset to Default</button><br/>
		<p id="note" style="color: #757575; display: none;">
			<strong>Note:</strong><br/>The colour picker feature is not fully supported by all browsers.
		</p><br/>
		<!--<input id="colour_picker2" name="colour2" type="text" style="visibility: hidden; display: block;"/>-->
		<input class="button" type="submit" value="Save Settings"/>
	</form><br/>
</div>
<script>
	var colours;

	if(name == "IE" || name == "Edge" || name == "Safari" || name == "Opera Mini") {
		showColourInputField();
	}
	
	function selectColour(colour) {
		document.getElementById("colour_picker").value = colour;
		document.getElementById("colour_picker_ie").value = colour;
	}
	
	function showPresets() {
		if(!window.focus) {
			return true;
		}
		
		var link = "./app/views/settings/colours.php";
		colours = window.open(link, "_blank", "width=800, height=500, scrollbars=yes, modal=yes, alwaysRaised=yes, location=0");
		
		return false;
	}
	
	function closePresets() {
		colours.close();
	}
</script>