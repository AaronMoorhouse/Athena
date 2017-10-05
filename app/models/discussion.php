<?php
require_once("lib/model.php");

class Discussion extends Model {
	
	/*
	* Get all general or team discussions.
	*/
	public function getAllDiscs($teamId = 0) {
		$this->connect();
		$params = array();
		
		if($teamId == 0) {
			$sql = file_get_contents("app/webroot/sql/get_general_discs.sql");
		}
		else {
			$sql = file_get_contents("app/webroot/sql/get_team_discs.sql");
			$params['team'] = $teamId;
		}
		
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		return $result;
	}
	
	/*
	* Get discussions a specific user is involved in.
	*/
	public function getInvolvedDiscs($id) {
		$this->connect();
		$sql = file_get_contents("app/webroot/sql/get_involved_discs.sql");
		$params = array("id" => $id);
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Get data of a specific discussion.
	*/
	public function getDisc($id, $type = "General") {
		$this->connect();
		
		if($type == "General") {
			$sql = file_get_contents("app/webroot/sql/get_disc.sql");
		}
		else {
			$sql = file_get_contents("app/webroot/sql/get_team_disc.sql");
		}
		
		$params = array("id" => $id);
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result[0];
	}
	
	/*
	* Get the team a specific discussion belongs to.
	*/
	public function getDiscTeam($discId) {
		$this->connect();
		$sql = "SELECT team_id FROM teams_discussions WHERE discussion_id = :id";
		$params = array("id" => $discId);
		$result = $this->runSelectQuery($sql, $params);
		
		if(isset($result[0]['team_id'])) {
			return $result[0]['team_id'];
		}
		
		return 0;
	}
	
	/*
	* Add a new discussion to the database
	*/
	public function addDisc($userId, $subject, $teamId = 0) {
		$this->connect();
		$sql = "INSERT INTO $this->table (user_id, subject, created, disc_type) VALUES (:user, :sub, :date, :type)";
		$params = array("user" => $userId, "sub" => $subject, "date" => date("Y-m-d H:i:s"));
		
		if($teamId > 0) {
			$params["type"] = "Team";
		}
		else {
			$params["type"] = "General";
		}
		
		$result = $this->runQuery($sql, $params);
		
		if(isset($result) && $teamId > 0) {
			//Update teams_discussions table
			$sql = "INSERT INTO teams_discussions (team_id, discussion_id) VALUES (:team, :disc)";
			$params = array("team" => $teamId, "disc" => $result);
			
			if(!$this->runQuery($sql, $params)) {
				return 0;
			}
		}
		
		$this->disconnect();
		return $result;
	}
}
?>