<?php
include_once("lib/model.php");

class Login extends Model {
	
	public function __construct() {
		Model::__construct("users");
	}
	
	/*
	* Verify a user's password against the hash in database.
	*/
	public function checkDetails($email, $password) {
		$this->connect();
		$sql = "SELECT * FROM $this->table WHERE email = :email";
		$params = array("email" => $email);
		$result = $this->runSelectQuery($sql, $params);
		$user = $result[0];
		
		if($user) {
			$options = array("cost" => 12);
			
			//Verify password
			if(password_verify($password, $user['password_bcrypt'])) {
				//Check if password needs rehashing
				if(password_needs_rehash($user['password_bcrypt'], PASSWORD_BCRYPT, $options)) {
					//Rehash password
					$hash = password_hash($password, PASSWORD_BCRYPT, $options);
					//Update password
					$this->update("password_bcrypt", $hash, "user_id", $userId);
				}
				
				$this->disconnect();
				return $user;
			}
		}
		
		$this->disconnect();
		return 0;
	}
	
	/*
	* Update last login time of a user.
	*/
	public function updateLastLogin($userId) {
		$this->connect();
		$this->update("last_login", date("Y-m-d H:i:s"), "user_id", $userId);
		$this->disconnect();
	}
	
	/*
	* Check if an email address exists in database.
	*/
	public function emailExists($email) {
		$this->connect();
		$sql = "SELECT * FROM $this->table WHERE email = :email";
		$params = array("email" => $email);
		$result = $this->runSelectQuery($sql, $params);
		
		if(count($result) > 0) {
			return $result[0]['user_id'];
		}
		
		return 0;
	}
}
?>