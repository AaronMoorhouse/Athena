<?php
class Helper {
	
	private $html;
	
	protected function prepare($html) {
		$this->html = $html;
	}
	
	protected function output($params = array()) {
		$html = $this->html;
		
		foreach($params as $placeholder => $value) {
			$html = str_replace($placeholder, $value, $html);
		}
		
		echo $html;
	}
}