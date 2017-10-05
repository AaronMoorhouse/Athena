<?php
require_once("lib/controller.php");

class TasksController extends Controller {
	
	//Teams model
	private $teamModel;
	
	public function __construct($model, $controller, $action) {
		Controller::__construct($model, $controller, $action);
		$this->teamModel = $this->loadModel('team');
	}
	
	public function index() {
		$this->redirect(array("controller" => "teams"));
	}
	
	/*
	* Tasks page.
	*/
	public function view($id = 0) {
		if(isset($id) && $id > 0) {
			//Get team data
			$team = $this->teamModel->getTeam($id);
			//Get user id
			$user = $_SESSION['user']['user_id'];
			
			//Check user is a member
			if($this->teamModel->isMember($user, $id)) {
				//Get team members
				$members = $this->teamModel->getMembers($id);
				//Get tasks
				$tasks = $this->model->getTeamTasks($id);
				
				// foreach($members as $member) {
					// if($member['user_id'] == $user) {
						// $isAdmin = $member['admin_status'];
						// break;
					// }
				// }
				
				// if(isset($isAdmin)) {
					// $this->set('isAdmin', $isAdmin);
				// }
				
				//Pass data to views
				$this->set('title', $team['team_name'] . ' - Athena');
				$this->set('activeLink', 'Teams');
				$this->set('team', $team);
				$this->set('tasks', $tasks);
				$this->set('members', $members);
				$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
			else {
				$this->redirect(array("controller" => "teams"));
			}
		}
		else { 
			$this->redirect(array("controller" => "teams"));
		}
	}
	
	/*
	* Edit a task.
	*/
	public function edit($id = 0) {
		if(isset($id) && $id > 0) {
			//Get user id
			$user = $_SESSION['user']['user_id'];
			//Get task info
			$task = $this->model->getTask($id);
			
			//Check user is a team member
			if(isset($task) && $this->teamModel->isMember($user, $task['team_id'])) {
				//Get team data
				$team = $this->teamModel->getTeam($task['team_id']);
				//Get team members
				$members = $this->teamModel->getMembers($task['team_id']);
				
				//Pass data to views
				$this->set('title', 'Edit Task - Athena');
				$this->set('activeLink', 'Teams');
				$this->set('task', $task);
				$this->set('team', $team);
				$this->set('members', $members);
				$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			}
			else {
				$this->redirect('last');
			}
		}
		else {
			$this->redirect(array("controller" => "teams"));
		}
	}
	
	/*
	* Add a task.
	*/
	public function add($id = 0) {
		if($_SERVER['REQUEST_METHOD'] == "POST" && $id > 0) {
			//Task name
			$task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
			//Start date
			$startDate = DateTime::createFromFormat("m/d/Y", $_POST['start']);
			//End date
			$endDate = DateTime::createFromFormat("m/d/Y", $_POST['end']);
			//Format dates for database
			$start = $startDate->format("Y-m-d");
			$end = $endDate->format("Y-m-d");
			
			//Add the task to database
			if($this->model->addTask($id, $_POST['user'], $_POST['task'], $start, $end)) {
				$_SESSION['msg'] = "Task successfully created";
			}
			else {
				$_SESSION['msg-err'] = "Task could not be created";
			}
			
			$this->redirect(array("controller" => $this->controller, "action" => "view", "params" => array($id)));
		}
		
		$this->redirect(array("controller" => "teams"));
	}
	
	/*
	* Update task info.
	*/
	public function update($id = 0) {
		if($_SERVER['REQUEST_METHOD'] == "POST" && $id > 0) {
			//Task name
			$task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
			//Start date
			$startDate = DateTime::createFromFormat("m/d/Y", $_POST['start']);
			//End date
			$endDate = DateTime::createFromFormat("m/d/Y", $_POST['end']);
			//Format dates for database
			$start = $startDate->format("Y-m-d");
			$end = $endDate->format("Y-m-d");
			
			//Update task info in database
			if(!$this->model->updateTask($id, $_POST['user'], $task, $start, $end)) {
				$_SESSION['msg-err'] = "Task could not be updated";
			}
			else {
				$_SESSION['msg'] = "Task successfully updated";
			}
			
			$team = $this->model->getTask($id)['team_id'];
			$this->redirect(array("controller" => $this->controller, "action" => "view", "params" => array($team)));
		}
		
		$this->redirect(array("controller" => "teams"));
	}
	
	/*
	* Mark a task as complete/incomplete.
	*/
	public function markComplete() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//Set completion status
			if(!$this->model->setComplete($_POST['tsk'], $_POST['comp'])) {
				$_SESSION['msg-err'] = "Task could not be updated";
			}
		}
		
		$this->redirect('last');
	}
	
	/*
	* Delete a task.
	*/
	public function remove() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//Remove from database
			if(!$this->model->deleteTask($_POST['del'])) {
				$_SESSION['msg-err'] = "Task could not be removed";
			}
			else {
				$_SESSION['msg'] = "Task successfully removed";
			}
		}
		
		$this->redirect(array("controller" => "teams"));
	}
}
?>