<?php
require_once("Validator.php");

class UserValidator extends Validator {
	
	/*
	* Validate a user's name.
	*/
	public function validateName($fname, $sname) {
		$regex = "/^[A-Za-z-\s]*$/";
		
		if($this->validate($regex, $fname) && $this->validate($regex, $sname)) {
			return true;
		}
		
		return false;
	}
	
	/*
	* Validate a user's password to check it passes the password requirements.
	*/
	public function validatePassword($pass) {
		$regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/";
		
		return $this->validate($regex, $pass);
	}
}
?>