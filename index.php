<?php
session_start();
require_once('app/config/config.php');

$controller = "";
$action = "";

if(isset($_GET['url'])) {
	$url = $_GET['url'];
	$urlArray = explode("/", $url);
	$controller = $urlArray[0];
	
	if(isset($urlArray[1])) {
		$action = $urlArray[1];
	}
}

if($controller != "login" && $controller != "register") {
	if(!isset($_SESSION['last']) && $_SERVER['REQUEST_METHOD'] != "POST" && !($controller == "pages" && $action == "error")) {
		$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	
	if(!isset($_SESSION['user'])) {
		header("Location: " . ROOT . "/login");
		exit;
	}
}

// if((isset($controller) && $controller != "login") || !isset($_GET['url'])) {
	// if(!isset($_SESSION['last']) && $_SERVER['REQUEST_METHOD'] != "POST" && (isset($urlArray[1]) && $urlArray[1] != "error")) {
		// $_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	// }
	
	// if(!isset($_SESSION['user'])) {
		// header("Location: ./login");
		// exit;
	// }
// }

require_once('lib/router.php');
?>