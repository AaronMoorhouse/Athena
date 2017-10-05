<?php
require_once("lib/model.php");

class Team extends Model {
	
	/*
	* Add a team to the database.
	*/
	public function add($name) {
		$this->connect();
		$sql = "INSERT INTO $this->table (team_name) VALUES (:name)";
		$params = array("name" => $name);
		$result = $this->runQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Get teams the user belongs to.
	*/
	public function getTeams($userId) {
		$this->connect();
		$sql = file_get_contents("app/webroot/sql/get_teams.sql");
		$params = array("id" => $userId);
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Get data for a specific team.
	*/
	public function getTeam($id) {
		$this->connect();
		$sql = "SELECT * FROM teams WHERE team_id = :id";
		$params = array("id" => $id);
		$result = $this->runSelectQuery($sql, $params)[0];
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Update a team's name.
	*/
	public function updateTeamName($id, $newName) {
		$this->connect();
		$result = $this->update("team_name", $newName, "team_id", $id);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Add a new member to a team.
	*/
	public function addMember($userId, $teamId, $admin = 0) {
		$this->connect();
		$sql = "INSERT INTO teams_users (team_id, user_id, admin_status) VALUES (:team, :user, :admin)";
		$params = array("team" => $teamId, "user" => $userId, "admin" => $admin);
		$result = $this->runQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Remove a member from a team.
	*/
	public function removeMember($userId, $teamId) {
		$this->connect();
		$sql = "DELETE FROM teams_users WHERE team_id = :team AND user_id = :user";
		$params = array("team" => $teamId, "user" => $userId);
		$result = $this->runQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Update the admin status of a member of a team.
	*/
	public function setAdminStatus($userId, $teamId, $status) {
		$this->connect();
		$sql = "UPDATE teams_users SET admin_status = :stat WHERE user_id = :user AND team_id = :team";
		$params = array("stat" => $status, "user" => $userId, "team" => $teamId);
		$result = $this->runQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Get members of a specific team
	*/
	public function getMembers($id) {
		$this->connect();
		$sql = file_get_contents("app/webroot/sql/get_team_members.sql");
		$params = array("id" => $id);
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Check if a user belongs to a specific teams.
	*/
	public function isMember($userId, $teamId) {
		$this->connect();
		$sql = "SELECT user_id FROM teams_users WHERE user_id = :usr AND team_id = :team";
		$params = array("usr" => $userId, "team" => $teamId);
		$result = $this->runSelectQuery($sql, $params)[0];
		$this->disconnect();
		
		if(isset($result['user_id'])) {
			return $result['user_id'];
		}
		
		return 0;
	}
}
?>