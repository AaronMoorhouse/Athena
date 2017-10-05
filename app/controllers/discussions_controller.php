<?php
require_once("lib/controller.php");

class DiscussionsController extends Controller {
	
	//Posts model
	private $postModel;
	
	public function __construct($model, $controller, $action) {
		Controller::__construct($model, $controller, $action);
		$this->postModel = $this->loadModel('post');
	}
	
	public function index() {
		$this->redirect(array('controller' => $this->controller, 'action' => 'general'));
	}
	
	/*
	* General Discussions page.
	*/
	public function general() {
		//Get discussions
		$discs = $this->model->getAllDiscs();
		$initPosts = array();
		$postCounts = array();
		
		//Get initial post for each discussion
		for($i = 0; $i < count($discs); $i++) {
			$posts = $this->postModel->getPosts($discs[$i]['discussion_id']);
			$initPosts[$i] = $posts[0];
			$postCounts[$i] = count($posts);
		}
		
		//Pass data to view
		$this->set('title', 'General Discussions - Athena');
		$this->set('activeLink', 'Discussions');
		$this->set('discs', $discs);
		$this->set('posts', $initPosts);
		$this->set('postCounts', $postCounts);
		$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	
	/*
	* Team Discussions page.
	*/
	public function team($id = 0) {
		if(isset($id) && $id > 0) {
			//Get discussions
			$discs = $this->model->getAllDiscs($id);
			//User id
			$user = $_SESSION['user']['user_id'];
			//Initialise teams model
			$teamModel = $this->loadModel('team');
			//Get team data
			$team = $teamModel->getTeam($id);
			
			//Check user is a team member
			if(!$teamModel->isMember($user, $id)) {
				$this->redirect(array("controller" => "teams"));
			}
			
			$initPosts = array();
			$postCounts = array();
			
			//Get initial post for each discussion
			for($i = 0; $i < count($discs); $i++) {
				$posts = $this->postModel->getPosts($discs[$i]['discussion_id']);
				$initPosts[$i] = $posts[0];
				$postCounts[$i] = count($posts);
			}
			
			//Pass data to view
			$this->set('title', 'Team Discussions - ' . $team['team_name'] . ' - Athena');
			$this->set('activeLink', 'Discussions');
			$this->set('discs', $discs);
			$this->set('team', $team);
			$this->set('posts', $initPosts);
			$this->set('postCounts', $postCounts);
			$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		else {
			$this->redirect(array("controller" => $this->controller));
		}
	}
	
	/*
	* Discussion page.
	*/
	public function view($id = 0) {
		if(isset($id) && $id > 0) {
			//Get discussion info
			if($disc = $this->model->getDisc($id)) {
				if($disc['disc_type'] == "Team") {
					//Get team the discussion belongs to
					$team = $this->model->getDiscTeam($id);
					//User id
					$user = $_SESSION['user']['user_id'];
					//Initialise team model
					$teamModel = $this->loadModel('team');
					
					if($teamModel->isMember($user, $team)) {
						//Get team data
						$team = $teamModel->getTeam($id);
						//Get discussion info
						$disc = $this->model->getDisc($id, "Team");
						
						$this->set('team', $team);
					}
					else {
						$this->redirect(array("controller" => "teams"));
					}
				}
				
				//Get posts
				$posts = $this->postModel->getPosts($id);
				
				//Pass data to view
				$this->set('title', $disc['subject'] . ' - Athena');
				$this->set('activeLink', 'Discussions');
				$this->set('disc', $disc);
				$this->set('posts', $posts);
				$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
			else {
				$this->redirect(array("controller" => $this->controller));
			}
		}
		else {
			$this->redirect(array("controller" => $this->controller));
		}
	}
	
	/*
	* Add new discussion.
	*/
	public function addDisc($teamId = 0) {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//User id
			$user = $_SESSION['user']['user_id'];
			//$type = ucfirst($type);
			
			//Add discussion to database
			if($id = $this->model->addDisc($user, $_POST['subject'], $teamId)) {
				//Create initial post
				if($this->postModel->addPost($id, $user, $_POST['post'])) {
					$this->redirect(array("controller" => $this->controller, "action" => "view", "params" => array($id)));
				}
				else {
					$_SESSION['msg-err'] = "Post could not be created";
				}
			}
			else {
				$_SESSION['msg-err'] = "Discussion could not be created";
			}
		}
		
		$this->redirect(array("controller" => $this->controller));
	}
	
	/*
	* Add a post to a discussion.
	*/
	public function addPost($id = 0) {
		if($_SERVER['REQUEST_METHOD'] == "POST" && $id > 0) {
			//User id
			$user = $_SESSION['user']['user_id'];
			
			//Add post to database
			if($this->postModel->addPost($id, $user, $_POST['post'])) {
				$this->redirect(array("controller" => $this->controller, "action" => "view", "params" => array($id)));
			}
			else {
				$_SESSION['msg-err'] = "Post could not be created";
			}
		}
		
		$this->redirect(array("controller" => $this->controller));
	}
}
?>