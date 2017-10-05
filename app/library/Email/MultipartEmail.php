<?php
/**
 * Class for sending MIME standard emails, which contain both plain-text and HTML versions.
 * The client determines which is displayed based on client settings/compatibility.
 *
 * @package Email
 * @author Aaron Moorhouse
 * @version 1.0
 */

require_once("Email.php");

class MultipartEmail extends Email {
	
	public function __construct($subject, $plain, $html) {
		$boundary = "==MULTIPART_BOUNDARY_" . md5(time());
		
		//Plain text
		$msg = "--$boundary\n";
		$msg .= "Content-Type: text/plain; charset=iso-8859-1\n";
		$msg .= "Content-Transfer-Encoding: 7bit\n\n";
		$msg .= "$plain\n\n";
		
		//HTML
		$msg .= "--$boundary\n";
		$msg .= "Content-Type: text/html; charset=iso-8859-1\n";
		$msg .= "Content-Transfer-Encoding: 7bit\n\n";
		$msg .= "$html\n\n";
		
		$msg .= "--$boundary--";
		
		Email::__construct($subject, $msg);
		$this->headers .= "Content-Type: multipart/alternative; boundary=\"".$boundary."\"\n";
		$this->headers .= "Content-Transfer-Encoding: 7bit\n";
		$this->headers .= "MIME-Version: 1.0\n";
	}
}
?>