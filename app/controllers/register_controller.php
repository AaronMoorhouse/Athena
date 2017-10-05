<?php
include_once("lib/controller.php");

class RegisterController extends Controller {
	
	public function __construct($model, $controller, $action) {
		Controller::__construct("login", $controller, $action);
	}
	
	/*
	* Register page.
	*/
	public function index() {
		if(isset($_SESSION['user'])) {
			$this->redirect(ROOT);
		}
		
		$this->set('title', 'Register - Athena');
	}
	
	/*
	* Register a new user.
	*/
	public function registerUser() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//Initialise validator component
			$validator = $this->loadComponent('UserValidator');
			//Initialise user model
			$userModel = $this->loadModel('user');
			
			//Validate user's name
			if($validator->validateName($_POST['fname'], $_POST['sname'])) {
				//Check desired password correctly entered twice
				if($_POST['pass'] == $_POST['pass2']) {
					//Validate password against requirements
					if($validator->validatePassword($_POST['pass'])) {
						//Check if the email address already exists
						if(!$this->model->emailExists($_POST['email'])) {
							//Add user to database
							if($userModel->addUser($_POST['fname'], $_POST['sname'], $_POST['email'], $_POST['pass'])) {
								$_SESSION['msg'] = 'Account successfully created. Log in <a href="'.ROOT.'/login">here</a>';
							}
							else {
								$_SESSION['msg-err'] = "User account could not be created";
							}
						}
						else {
							$_SESSION['msg-err'] = "Email address already in use";
						}
					}
					else {
						$_SESSION['msg-err'] = "Please enter a valid password";
					}
				}
				else {
					$_SESSION['msg-err'] = "Passwords do not match";
				}
			}
			else {
				$_SESSION['msg-err'] = "Please enter a valid name";
			}
			
			$this->redirect(array('controller' => 'register', 'action' => ''));
		}
		else {
			$this->redirect(ROOT);
		}
	}
}
?>