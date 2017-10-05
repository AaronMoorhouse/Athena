<?php
require_once("lib/model.php");

class Invite extends Model {
	
	/*
	* Add a new invite to database.
	*/
	public function addInvite($userId, $teamId) {
		$this->connect();
		$sql = "INSERT INTO $this->table (user_id, team_id) VALUES (:user, :team)";
		$params = array("user" => $userId, "team" => $teamId);
		$result = $this->runQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	// public function setInviteStatus($id, $status) {
		// $this->connect();
		// $result = $this->update("accepted", $status, "invite_id", $id);
		// $this->disconnect();
		
		// return $result;
	// }
	
	/*
	* Get invites sent to a specific user.
	*/
	public function getInvites($userId) {
		$this->connect();
		$sql = file_get_contents("app/webroot/sql/get_invites.sql");
		$params = array("id" => $userId);
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Get data for a specific invite in database.
	*/
	public function getInvite($id) {
		$this->connect();
		$result = $this->select("invite_id", $id);
		$this->disconnect();
		
		if($result) {
			return $result;
		}
		
		return 0;
	}
	
	/*
	* Check if a user has a pending invite from a specific team.
	*/
	public function hasInvite($userId, $teamId) {
		$this->connect();
		$sql = "SELECT invite_id FROM $this->table WHERE user_id = :user AND team_id = :team";
		$params = array("user" => $userId, "team" => $teamId);
		$result = $this->runSelectQuery($sql, $params)[0];
		$this->disconnect();
		
		if($result) {
			return result;
		}
		
		return 0;
	}
	
	/*
	* Remove an invite from database.
	*/
	public function deleteInvite($id) {
		$this->connect();
		$sql = "DELETE FROM $this->table WHERE invite_id = :id";
		$params = array("id" => $id);
		$result = $this->runQuery($sql, $params);
		
		$this->disconnect();
		return result;
	}
}
?>