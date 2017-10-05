<?php
require_once("lib/controller.php");

class TeamsController extends Controller {
	
	//Invites model
	private $inviteModel;
	
	public function __construct($model, $controller, $action) {
		Controller::__construct($model, $controller, $action);
		$this->inviteModel = $this->loadModel('invite');
	}
	
	/*
	* Teams page.
	*/
	public function index() {
		//Get user data from session
		$user = $_SESSION['user']['user_id'];
		//Get teams list
		$teams = $this->model->getTeams($user);
		//Get number of team invites
		$invites = count($this->inviteModel->getInvites($user));
		$members = array();
		
		//Get members of each team
		if(count($teams) > 0) {
			foreach($teams as $team) {
				$members[$team['team_id']] = $this->model->getMembers($team['team_id']);
			}
		}
		
		//Pass data to view
		$this->set('title', 'Teams - Athena');
		$this->set('activeLink', 'Teams');
		$this->set('teams', $teams);
		$this->set('members', $members);
		$this->set('invites', $invites);
		$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	
	/*
	* Manage team page.
	*/
	public function manage($id = 0) {
		//Get user data from session
		$user = $_SESSION['user']['user_id'];
		
		if(isset($id) && $id > 0 && $this->model->isMember($user, $id)) {
			//Get team data
			$team = $this->model->getTeam($id);
			//Get team members
			$members = $this->model->getMembers($id);
			
			//Get user's admin status
			if(count($members)) {
				foreach($members as $member) {
					if($member['user_id'] == $user) {
						$isAdmin = $member['admin_status'];
						break;
					}
				}
			}
			
			if(isset($isAdmin)) {
				if(isset($_SESSION['search'])) {
					$this->set('users', $_SESSION['search']);
					unset($_SESSION['search']);
				}
				
				//Pass data to view
				$this->set('title', 'Manage - ' . $team['team_name'] . ' - Athena');
				$this->set('activeLink', 'Teams');
				$this->set('team', $team);
				$this->set('members', $members);
				$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
			else {
				$this->redirect(array("controller" => "tasks", "action" => "view", "params" => array($id)));
			}
		}
		else {
			$this->redirect(array("controller" => $this->controller));
		}
	}
	
	/*
	* Team invites page.
	*/
	public function invites() {
		//Get user data
		$user = $_SESSION['user']['user_id'];
		//Get team invites
		$invites = $this->inviteModel->getInvites($user);
		$members = array();
		
		//Get members of the teams that send each invite
		if(count($invites) > 0) {
			foreach($invites as $invite) {
				$members[$invite['team_id']] = $this->model->getMembers($invite['team_id']);
			}
		}
		
		//Pass data to view
		$this->set('title', 'Team Invites - Athena');
		$this->set('activeLink', 'Teams');
		$this->set('invites', $invites);
		$this->set('members', $members);
		$_SESSION['last'] = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	
	/*
	* Respond to a team invite.
	*/
	public function respond() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//Get user id
			$userId = $_SESSION['user']['user_id'];
			
			//Invite to respond to
			$inviteId = $_POST['invite'];
			//Get invite
			$invite = $this->inviteModel->getInvite($inviteId);
			
			//Accept
			if($_POST['response'] == 1) {
				//Add user to team
				if($this->model->addMember($userId, $invite['team_id'])) {
					//Delete the invite
					if($this->inviteModel->deleteInvite($inviteId)) {
						$_SESSION['msg'] = "Invite accepted";
						$this->redirect(array("controller" => $this->controller, $action => "invites"));
					}
					else {
						$_SESSION['msg-err'] = "Error: Unable to accept invite";
					}
				}
				else {
					$_SESSION['msg-err'] = "Error: Unable to join team";
				}
			}
			//Reject
			else {
				//Delete the invite
				if($this->inviteModel->deleteInvite($inviteId)) {
					$_SESSION['msg'] = "Invite rejected";
					$this->redirect(array("controller" => $this->controller, $action => "invites"));
				}
				else {
					$_SESSION['msg-err'] = "Error: Unable to reject invite";
				}
			}
		}
		
		$this->redirect(array("controller" => $this->controller));
	}
	
	/*
	* Add a new team.
	*/
	public function addTeam() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//Get user id
			$userId = $_SESSION['user']['user_id'];
			
			//Create team
			if($teamId = $this->model->add($_POST['team_name'])) {
				//Add the creator to team
				if($this->model->addMember($userId, $teamId, 1)) {
					$_SESSION['msg'] = "Team successfully created";
					$this->redirect(array("controller" => "tasks", "action" => "view", "params" => array($teamId)));
				}
				else {
					$_SESSION['msg-err'] = "Error: Unable to add user to team";
				}
			}
			else {
				$_SESSION['msg-err'] = "Error: Unable to create team";
			}
		}
		
		$this->redirect(array("controller" => $this->controller));
	}
	
	/*
	* Edit a team's name.
	*/
	public function editTeamName($id) {
		if($_SERVER['REQUEST_METHOD'] == "POST" && $id > 0) {
			//New name for team
			$newName = $_POST['team_name'];
			
			//Update the team name
			if($this->model->updateTeamName($id, $newName)) {
				$_SESSION['msg'] = "Team name successfully updated";
			}
			else {
				$_SESSION['msg-err'] = "An error occurred";
			}
		}
		
		$this->redirect('last');
	}
	
	/*
	* Search database for users.
	*/
	public function searchUsers() {
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			//Initialise users model
			$userModel = $this->loadModel('user');
			//Search users
			$users = $userModel->searchUsers($_POST['search']);
			
			$_SESSION['search'] = array(1, $users);
			$this->redirect($_SESSION['last']."#add");
		}
		
		$this->redirect('last');
	}
	
	/*
	* Send invite to join team.
	*/
	public function addMembers($id = 0) {
		if($_SERVER['REQUEST_METHOD'] == "POST" && $id > 0) {
			//Users to send invite to
			$users = $_POST['members'];
			$memberIds = array();
			$members = $this->model->getMembers($id);
			
			//Add member ids to array
			foreach($members as $member) {
				array_push($memberIds, $member['user_id']);
			}
			
			foreach($users as $user) {
				if(!in_array($user, $memberIds)) {
					// if(!$this->model->addMember($user['user_id'], $id)) {
						// unset($_SESSION['msg']);
						// $_SESSION['msg-err'] = "An error occurred";
					// }
					
					//Send invite to users if they don't have one from this team
					if(!$this->inviteModel->hasInvite($user, $id)) {
						if($this->inviteModel->addInvite($user, $id)) {
							$_SESSION['msg'] = "Team invite(s) sent";
						}
						else {
							$_SESSION['msg-err'] = "Error: Unable to send team invite(s)";
						}
					}
				}
			}
		}
		
		$this->redirect('last');
	}
	
	/*
	* Remove member from team
	*/
	public function removeMember($id = 0) {
		if($_SERVER['REQUEST_METHOD'] == "POST" && $id > 0) {
			//Remove member
			if($this->model->removeMember($_POST['user'], $id)) {
				$_SESSION['msg'] = "User removed from team";
			}
			else {
				$_SESSION['msg-err'] = "An error occurred";
			}
		}
		
		$this->redirect('last');
	}
	
	/*
	* Grant or revoke admin status.
	*/
	public function setAdmin($id = 0) {
		if($_SERVER['REQUEST_METHOD'] == "POST" && $id > 0) {
			//Set admin status
			if($this->model->setAdminStatus($_POST['selected'], $id, $_POST['status'])) {
				$_SESSION['msg'] = "Admin status updated";
			}
			else {
				$_SESSION['msg-err'] = "An error occurred";
			}
		}
		
		$this->redirect('last');
	}
	
	/*
	* Send email notification.
	*/
	public function sendEmail($id = 0) {
		if($_SERVER['REQUEST_METHOD'] == "POST" && $id > 0) {
			//Initialise emailer component
			$mailer = $this->loadComponent('EmailHandler');
			//Get team members
			$members = $this->model->getMembers($id);
			//Get team name
			$team = $this->model->getTeam($id)['team_name'];
			
			//Send email to team members
			if($mailer->sendEmails($members, $team, $_POST['subject'], $_POST['content'])) {
				$_SESSION['msg'] = "Email sent";
			}
			else {
				$_SESSION['msg-err'] = "Error: Unable to send email";
			}
		}
		
		$this->redirect('last');
	}
}
?>