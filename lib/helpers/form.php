<?php
require_once("helper.php");

class Form extends Helper {
	
	public function create($action, $method = "post") {
		$this->prepare('<form action=":act" method=":meth">');
		$this->output(array(":act" => $action, ":meth" => $method));
	}
	
	public function input($type, $label = null) {
		
	}
	
	public function close() {
		$this->prepare('</form>');
		$this->output();
	}
}