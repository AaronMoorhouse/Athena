<?php
require_once("lib/template.php");

class Controller {
	
	protected $model;
	protected $controller;
	protected $action;
	protected $template;
	
	public function __construct($model, $controller, $action) {
		if($model) {
			$this->loadModel(strtolower($model));
			$this->model = new $model();
		}
		else {
			$this->model = $model;
		}
		
		$this->controller = $controller;
		$this->action = $action;
		$this->template = new Template($controller, $action);
	}
	
	public function __destruct() {
		if($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$this->template->render();
		}
	}
	
	public function set($key, $value) {
		$this->template->set($key, $value);
	}
	
	public function redirect($params) {
		if(is_array($params)) {
			if(PRETTY_URL) {
				$url = ROOT . "/" . $params['controller'];
				
				if(isset($params['action'])) {
					$url .= "/" . $params['action'];
				}
				
				if(isset($params['params'])) {
					foreach($params['params'] as $param) {
						$url .= "/" . $param;
					}
				}
			}
			else {
				$url = "?c=" . $params['controller']. "&a=" . $params['action'];
				
				if(isset($params['params'])) {
					foreach($params['params'] as $param => $value) {
						$url .= "&" . $param . "=" . $value;
					}
				}
			}
			
			header("Location: $url");
		}
		else if($params == 'error') {
			$this->redirect(array("controller" => "pages", "action" => "error"));
		}
		else if($params == 'last' && isset($_SESSION['last'])) {
			header("Location: " . $_SESSION['last']);
		}
		else {
			header("Location: " . $params);
		}
		
		exit;
	}
	
	protected function loadHelper($class) {
		if(file_exists('app/helpers/'. $class . '.php')) {
			require_once('app/helpers/'. $class . '.php');
			$this->set($class, new $class);
		}
		else if(file_exists('lib/helpers/'. $class . '.php')) {
			require_once('lib/helpers/'. $class . '.php');
			$this->set($class, new $class);
		}
		else {
			exit("Error: Helper '$class' not found.");
		}
	}
	
	protected function loadModel($class) {
		if(file_exists('app/models/' . $class . '.php')) {
			require_once('app/models/' . $class . '.php');
			return new $class;
		}
		
		exit("Error: Model '$class' not found.");
	}
	
	protected function loadComponent($class) {
		if(file_exists('app/components/' . $class . '.php')) {
			require_once('app/components/' . $class . '.php');
			return new $class;
		}
		
		exit("Error: Component '$class' not found.");
	}
}
?>