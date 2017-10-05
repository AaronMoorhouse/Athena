<?php
require_once("lib/model.php");

class User extends Model {
	
	/*
	* Add a user to database.
	*/
	public function addUser($fname, $sname, $email, $pass) {
		//Hash password
		$options = array("cost" => 12);
		$pass = password_hash($pass, PASSWORD_BCRYPT, $options);
		
		$this->connect();
		$sql = "INSERT INTO $this->table (first_name, surname, email, password_bcrypt) VALUES (:fname, :sname, :email, :pass)";
		$params = array("fname" => $fname, "sname" => $sname, "email" => $email, "pass" => $pass);
		$result = $this->runQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Get users from database that match search criteria.
	*/
	public function searchUsers($input) {
		$this->connect();
		$sql = file_get_contents('app/webroot/sql/search_users.sql');
		$params = array("string" => "%".$input."%");
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Update user's colour preference
	*/
	public function updateColour($userId, $col) {
		$this->connect();
		$result = $this->update('colour', $col, 'user_id', $userId);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Update user's email address.
	*/
	public function updateEmail($userId, $email) {
		$this->connect();
		$result = $this->update('email', $email, 'user_id', $userId);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Update user's password
	*/
	public function updatePassword($userId, $pass) {
		$this->connect();
		$result = $this->update('password_bcrypt', $pass, 'user_id', $userId);
		$this->disconnect();
		
		return $result;
	}
}
?>