<?php
/**
* A class for handling the process of sending emails to team members.
*
* @author Aaron Moorhouse
* @version 1.0
*/

require_once("lib/component.php");
//require_once('app/library/Email/MultipartEmail.php');
require_once('app/vendors/PHPMailer/PHPMailerAutoload.php');

class EmailHandler extends Component {
	
	/**
	* Send emails to team members.
	*/
	public function sendEmails($to, $from, $subject, $content) {
		//Create email object
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		$mail->IsSendmail(true);
		$mail->SetFrom("athena@selene.hud.ac.uk", $from . " (Athena)");
		$mail->Subject = $subject;
		
		//Plain text content
		$plain = strip_tags($content);
		
		//HTML content
		$html = file_get_contents("app/webroot/html/email/email.html");
		$html = str_replace("@subject", $subject, $html);
		$html = str_replace("@content", $content, $html);
		
		$mail->MsgHTML($html);
		$mail->AltBody = $plain;
		
		//Send to each user
		foreach($to as $user) {
			$mail->AddAddress($user['email']);
		}
		
		//$mail->AddAddress("aaron.moorhouse95@gmail.com");
		return $mail->Send();
	}
}
?>