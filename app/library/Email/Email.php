<?php
/**
 * Class for sending a standard plain-text or HTML email.
 *
 * @package Email
 * @author Aaron Moorhouse
 * @version 1.0
 */

class Email {
	
	protected $to, $subject, $msg, $headers;
	
	public function __construct($subject, $msg) {
		$this->to = "";
		$this->subject = $subject;
		$this->msg = $msg;
		$this->headers = "";
	}
	
	public function send() {
		$result = mail($this->to, $this->subject, $this->msg, $this->headers);
		return $result;
	}
	
	public function setCC($cc) {
		if(is_array($cc)) {
			if(count($cc) > 0) {
				$this->headers .= "CC: ";
				
				foreach($cc as $person) {
					$this->headers .= $person . ", ";
				}
			}
		}
		else {
			$this->headers .= "CC: $cc";
		}
		
		$this->headers .= "\n";
	}
	
	public function setBCC($bcc) {
		if(is_array($bcc)) {
			if(count($bcc) > 0) {
				$this->headers .= "BCC: ";
				
				foreach($bcc as $person) {
					$this->headers .= $person . ", ";
				}
			}
		}
		else {
			$this->headers .= "BCC: $bcc";
		}
		
		$this->headers .= "\n";
	}
	
	public function setFrom($from) {
		$this->headers .= "From: " . $from . "\n";
	}
	
	public function setHtml() {
		$this->headers .= "Content-Type: text/html; charset=iso-8859-1\n";
	}
	
	public function setTo($to) {
		if(is_array($to)) {
			if(count($to) > 0) {
				$this->to = "";
				
				foreach($to as $person) {
					$this->to .= $person . ", ";
				}
				
				return;
			}
		}
		
		$this->to = $to;
	}
}
?>