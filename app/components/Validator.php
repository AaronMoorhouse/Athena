<?php
/**
* A class for validating user input using regular expressions.
*
* @author Aaron Moorhouse
* @version 1.0
* @date 02/08/16
*/

require_once("lib/component.php");

class Validator extends Component {
	
	/**
	* Validate a string based on the given regular expression.
	*
	* @param regex - The regular expression used for validation.
	* @param string - The string to be validated.
	* @return True if the string is valid.
	*/
	public function validate($regex, $string) {
		if(preg_match($regex, $string)) {
			return true;
		}
		
		return false;
	}
}
?>