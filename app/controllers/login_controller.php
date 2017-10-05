<?php
require_once("lib/controller.php");

class LoginController extends Controller {
	
	/*
	* Login page.
	*/
	public function index() {
		if(isset($_SESSION['user'])) {
			$this->redirect(ROOT);
		}
	}
	
	/*
	* Log user in to system.
	*/
	public function userLogin() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//Entered email/password
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			//Verify details
			$user = $this->model->checkDetails($username, $password);
			
			if($user) {
				//Store user data in session
				$_SESSION['user'] = $user;
				
				//Update last login time
				$this->model->updateLastLogin($user['user_id']);
				
				if(isset($_SESSION['last'])) {
					$this->redirect('last');
				}
				else {
					$this->redirect(ROOT);
				}
			}
			else {
				$_SESSION['loginError'] = "The username/password is not valid";
				$this->redirect(array("controller" => "login"));
			}
		}
	}
	
	/*
	* Log user out of system.
	*/
	public function logout() {
		session_destroy();
		$this->redirect(array("controller" => "login"));
	}
}
?>