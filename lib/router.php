<?php
if(isset($_GET['url'])) {
	$url = $_GET['url'];
	$urlArray = explode("/", $url);

	if(isset($urlArray[0]) && isset($urlArray[1])) {
		$controller = $urlArray[0];
		array_shift($urlArray);
		$action = $urlArray[0];
		array_shift($urlArray);
		
		if($action == "") {
			$action = "index";
		}
		
		$params = $urlArray;
	}
	else if(isset($urlArray[0]) xor isset($urlArray[1])) {
		if(isset($urlArray[0])) {
			$controller = $urlArray[0];
			$action = "index";
		}
		else {
			$controller = "pages";
			$action = "error";
		}
		
		$params = array();
	}
}
else {
	$controller = "pages";
	$action = "index";
	$params = array();
}

if(!loadController($controller)) {
	$controller = "pages";
	$action = "error";
	$params = array();
}

call($controller, $action, $params);

function call($controller, $action, $params) {
	$model = rtrim(ucwords($controller), 's');
	$controllerName = ucwords($controller) . "Controller";
	$dispatch = new $controllerName($model, $controller, $action);
	
	if(method_exists($dispatch, $action)) {
		call_user_func_array(array($dispatch, $action), $params);
	}
	else {
		loadController("pages");
		$dispatch = new PagesController(null, "pages", "error");
		call_user_func_array(array($dispatch, "error"), array());
	}
}

function loadController($class) {
	$filename = $class . "_controller";
	$path = 'app/controllers/' . $filename . '.php';
	
	if(file_exists($path)) {
		require_once($path);
		return true;
	}
	
	require_once("app/controllers/pages_controller.php");
	return false;
}
?>