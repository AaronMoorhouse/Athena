<?php
if(isset($_SESSION['user']['colour'])) {
	$colour = $_SESSION['user']['colour'];
}
else {
	$colour = "#337399";
}

require_once("app/library/Colour/colour.php");
$col = new Colour($colour);
$lightness = $col->getLightness();
?>
<!DOCTYPE html>
<html>
<head>
	<base href="https://selene.hud.ac.uk/u1354494/athena/">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
	<link rel="stylesheet" type="text/css" href="app/webroot/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="apple-touch-icon" sizes="57x57" href="app/webroot/img/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="app/webroot/img/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="app/webroot/img/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="app/webroot/img/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="app/webroot/img/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="app/webroot/img/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="app/webroot/img/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="app/webroot/img/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="app/webroot/img/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="app/webroot/img/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="app/webroot/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="app/webroot/img/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="app/webroot/img/favicon-16x16.png">
	<link rel="manifest" href="app/webroot/img/manifest.json">
	<meta name="msapplication-TileColor" content="#337399">
	<meta name="msapplication-TileImage" content="app/webroot/img/ms-icon-144x144.png">
	<meta name="theme-color" <?php echo "content=\"$colour\""; ?>>
	<meta name="msapplicaion-navbutton-color" <?php echo "content=\"$colour\""; ?>>
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="app/webroot/js/compatibility.js"></script>
	<script src="app/webroot/js/ua-parser.js"></script>
	<script src="app/webroot/js/links.js"></script>
	<script src="app/webroot/js/colour.js"></script>
	<script src="app/webroot/js/time.js"></script>
	<title><?php echo $title; ?></title>
	<script>
		var uap = new UAParser();
		var name = uap.getResult().browser.name;
		var version = uap.getResult().browser.version;
	</script>
	<?php require_once("app/views/style.php"); ?>
</head>
<body>
	<?php include_once("analyticstracking.php"); ?>
	<ul id="mobile-menu">
		<?php if(isset($_SESSION['user'])) { ?>
			<li style="border: none">
				<a href="./settings">
					<?php
						if($lightness > 130) {
							echo ' <img src="app/webroot/img/Settings-Black.png" width="16"></img> ';
						}
						else {
							echo ' <img src="app/webroot/img/Settings.png" width="16"></img> ';
						}
						
						echo $_SESSION['user']['first_name']." ".$_SESSION['user']['surname'];
					?>
				</a>
			</li><br/>
		<?php } ?>
		<li><a href="./">Home</a></li>
		<li><a href="./teams">Teams</a></li>
		<li><a href="./discussions">Discussions</a></li>
		<!--<li><a href="./support">Support</a></li>-->
		<li><a href="./pages/feedback">Feedback</a></li>
		<?php if(isset($_SESSION['user'])) { ?><li><a href="./login/logout">Log out</a></li>
		<?php } else { ?><li><a href="./login">Log in</a></li><?php } ?>
	</ul>
	<input type="checkbox" id="menu-trigger" class="menu-trigger" />
	<label id="menu-icon" for="menu-trigger">
		<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' x='0px' y='0px' width='30px' height='30px' viewBox='0 0 30 30' enable-background='new 0 0 30 30' xml:space='preserve'>
			<rect width='30' height='6' fill='white'/>
			<rect y='24' width='30' height='6' fill='white'/>
			<rect y='12' width='30' height='6' fill='white'/>
		</svg>
	</label>
	<div class="wrapper">
		<div id="top">
			<nav id="menu">
				<ul>
					<li><a href="./">Home</a></li>
					<li><a href="./teams">Teams</a></li>
					<li><a href="./discussions">Discussions</a></li>
					<!--<li><a href="./support">Support</a></li>-->
					<li><a href="./pages/feedback">Feedback</a></li>
					<?php if(isset($_SESSION['user'])) { ?><li><a href="./login/logout">Log out</a></li>
					<?php } else { ?><li><a href="./login">Log in</a></li><?php } ?>
				</ul>
			</nav>
			<?php
				if(isset($_SESSION['user'])) {
					echo '<div><p><a href="./settings">';
					
					if($lightness > 130) {
						echo '<img src="app/webroot/img/Settings-Black.png" width="16"></img> ';
					}
					else {
						echo '<img src="app/webroot/img/Settings.png" width="16"></img> ';
					}
					
					echo $_SESSION['user']['first_name']." ".$_SESSION['user']['surname'];
					echo '</a></p></div>';
				}
			?>
			<img id="logo" src="app/webroot/img/logo-400.png"></img>
		</div>
		<?php if(isset($_SESSION['msg'])) { ?><div class="msg-green"><p><?php echo $_SESSION['msg']; unset($_SESSION['msg']);?></p></div><?php } ?>
		<?php if(isset($_SESSION['msg-err'])) { ?><div class="msg-red"><p><?php echo $_SESSION['msg-err']; unset($_SESSION['msg-err']);?></p></div><?php } ?>