<div id="content">
	<ul class="breadcrumbs">
		<li><a href="./">Home</a></li>
		<li><a href="./settings">Settings</a></li>
		<li>Change Password</li>
	</ul>
	<h1>Change Password</h1>
	<p>Here you can change your current password used to log in to the site.</p>
	<p><strong>Note:</strong><br/>Passwords must contain at least:</p>
	<ul>
		<li>8 characters in length.</li>
		<li>1 upper-case character.</li>
		<li>1 lower-case character.</li>
		<li>1 special character.</li>
		<li>1 numeric charater.</li>
	</ul>
	<form method="post" action="./settings/updatePassword">
		<label class="formlabel" for="current">Current Password:</label>
		<input class="formfield field" name="current" type="password" required>
		<label class="formlabel" for="new">New Password:</label>
		<input class="formfield field" name="new" type="password" required></br></br>
		<input class="button" type="submit" value="Submit"/>
	</form></br>
</div>