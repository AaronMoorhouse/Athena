<?php
include_once("lib/controller.php");

class PagesController extends Controller {
	
	public function __construct($model, $controller, $action) {
		Controller::__construct(null, $controller, $action);
	}
	
	/*
	* Home screen.
	*/
	public function index() {
		//User id
		$user = $_SESSION['user']['user_id'];
		//Initialise tasks model
		$taskModel = $this->loadModel('task');
		//Initialise discussions model
		$discModel = $this->loadModel('discussion');
		//Initialise posts model
		$postModel = $this->loadModel('post');
		
		//Get user's outstanding tasks
		$tasks = $taskModel->getUserTasks($user);
		//Get discussions user is involved in
		$discs = $discModel->getInvolvedDiscs($user);
		$initPosts = array();
		$postCounts = array();
		
		//Get initial posts for each discussion
		for($i = 0; $i < count($discs); $i++) {
			$posts = $postModel->getPosts($discs[$i]['discussion_id']);
			$initPosts[$discs[$i]['discussion_id']] = $posts[0];
			$postCounts[$discs[$i]['discussion_id']] = count($posts);
		}
		
		//Pass data to view
		$this->set('title', 'Home - Athena');
		$this->set('activeLink', 'Home');
		$this->set('tasks', $tasks);
		$this->set('discs', $discs);
		$this->set('posts', $initPosts);
		$this->set('postCounts', $postCounts);
		$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	
	/*
	* Error page.
	*/
	public function error() {
		$this->set('title', 'Error');
	}
	
	/*
	* Feedback page.
	*/
	public function feedback() {
		$this->set('title', 'Feedback - Athena');
		$this->set('activeLink', 'Feedback');
	}
}
?>