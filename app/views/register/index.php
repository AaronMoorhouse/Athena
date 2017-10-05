<div id="content">
	<h1>Register</h1>
	<p>Please fill in the details below to create a new account.</p>
	<p><strong>Note:</strong><br/>Passwords must contain at least:</p>
	<ul>
		<li>8 characters in length.</li>
		<li>1 upper-case character.</li>
		<li>1 lower-case character.</li>
		<li>1 special character.</li>
		<li>1 numeric charater.</li>
	</ul>
	<form action="./register/registerUser" method="post">
		<label class="formlabel" for="reg_fname">First Name:</label>
		<input id="reg_fname" class="formfield field" name="fname" type="text" required>
		<br/><br/>
		<label class="formlabel" for="reg_sname">Surname:</label>
		<input id="reg_sname" class="formfield field" name="sname" type="text" required>
		<br/><br/>
		<label class="formlabel" for="reg_email">Email Address:</label>
		<input id="reg_email" class="formfield field" name="email" type="email" required>
		<br/><br/>
		<label class="formlabel" for="reg_pass">Password:</label>
		<input id="reg_pass" class="formfield field" name="pass" type="password" required>
		<br/><br/>
		<label class="formlabel" for="reg_pass2">Re-enter Password:</label>
		<input id="reg_pass2" class="formfield field" name="pass2" type="password" required>
		<p id="pass_warning" style="color: red; display: none">Passwords do not match</p>
		<input class="formbutton button" type="submit" value="Submit">
	</form>
</div>
<script>
	var pass1, pass2;
	var warning = $('#pass_warning').get(0);
	//var warning = document.getElementById('pass_warning');

	$('#reg_pass').on('input', function() {
		pass1 = $(this).val();
		verify();
	});
	
	$('#reg_pass2').on('input', function() {
		pass2 = $(this).val();
		verify();
	});
	
	function verify() {
		if(pass1 != pass2) {
			warning.style.display = "block";
		}
		else {
			warning.style.display = "none";
		}
	}
</script>