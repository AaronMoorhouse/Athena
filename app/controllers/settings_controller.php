<?php
require_once("lib/controller.php");

class SettingsController extends Controller {
	
	public function __construct($model, $controller, $action) {
		Controller::__construct("user", $controller, $action);
	}
	
	/*
	* Settings page.
	*/
	public function index() {
		$this->set('title', 'Account Settings - Athena');
	}
	
	/*
	* Change password page.
	*/
	public function password() {
		$this->set('title', 'Change Password - Athena');
	}
	
	/*
	* Update the user settings.
	*/
	public function updateSettings() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//User id
			$user = $_SESSION['user']['user_id'];
			//Selected colour
			$col = $_POST['colour'];
			//User email
			$email = $_POST['email'];
			
			//Update user colour
			if($_SESSION['user']['colour'] != $col) {
				if($this->model->updateColour($user, $col)) {
					$_SESSION['user']['colour'] = $col;
				}
				else {
					$_SESSION['msg-err'] = "Error: Update Failed";
					$this->redirect(array("controller" => $this->controller, "action" => ""));
				}
			}
			
			//Update user email
			if($_SESSION['user']['email'] != $email) {
				if($this->model->updateEmail($user, $email)) {
					$_SESSION['user']['email'] = $email;
				}
				else {
					$_SESSION['msg-err'] = "Error: Update Failed";
					$this->redirect(array("controller" => $this->controller, "action" => ""));
				}
			}
			
			$_SESSION['msg'] = "Account successfully updated";
			$this->redirect('last');
		}
		else {
			$this->redirect(array("controller" => $this->controller, "action" => ""));
		}
	}
	
	/*
	* Update user's password.
	*/
	public function updatePassword() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//Entered value for current password
			$current = $_POST['current'];
			//New password
			$new = $_POST['new'];
			//User id
			$user = $_SESSION['user']['user_id'];
			//User email
			$email = $_SESSION['user']['email'];
			//Initialise login model
			$loginModel = $this->loadModel('login');
			//Initialise validator component
			$validator = $this->loadComponent('UserValidator');
			
			//Check current password is correct
			if($loginModel->checkDetails($email, $current)) {
				//Validate new password against requirements
				if($validator->validatePassword($new)) {
					//Hash password
					$options = array("cost" => 12);
					$bcrypt = password_hash($new, PASSWORD_BCRYPT, $options);
				
					//Update password in database
					if($this->model->updatePassword($user, $bcrypt)) {
						$_SESSION['user']['password_bcrypt'] = $bcrypt;
						$_SESSION['msg'] = "Password Successfully Updated";
						$this->redirect(array("controller" => $this->controller, "action" => ""));
					}
					else {
						$_SESSION['msg-err'] = "An error occurred";
					}
				}
				else {
					$_SESSION['msg-err'] = "Error: New password is invalid";
				}
			}
			else {
				$_SESSION['msg-err'] = "Error: Current password incorrect";
			}
			
			$this->redirect(array("controller" => $this->controller, "action" => "password"));
		}
		else {
			$this->redirect(array("controller" => $this->controller, "action" => ""));
		}
	}
}
?>