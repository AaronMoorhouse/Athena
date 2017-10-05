<div id="login">
	<img src="app/webroot/img/logo-purple-1200.png"></img>
	<?php
		if(isset($_SESSION['loginError'])) {
			echo '<div class="msg-red msg-login"><p>'.$_SESSION['loginError'].'</p></div>';
			unset($_SESSION['loginError']);
		}
	?>
	<form method="post" action="./login/userLogin">
		<label for="username">Email</label>
		<input id="username" class="field" name="username" type="text" required>
		<label for="password">Password</label>
		<input id="password" class="field" name="password" type="password" required>
		<br><br>
		<input class="button" value="Log In" type="submit">
	</form>
	<p>Don't have an account? Register <a href="./register">here</a>.</p>
</div>