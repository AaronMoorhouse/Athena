<?php
class Database {
	
	private $pdo = null;
	protected $table;
	
	public function connect() {
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$pdo_options[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
		$this->pdo = new PDO('mysql:host='. AUTH_HOST .';dbname='. AUTH_DATABASE, AUTH_USER, AUTH_PASS, $pdo_options);
	}
	
	public function disconnect() {
		$this->pdo = null;
	}
	
	public function selectAll($sortby = null) {
		try {
			if($sortby) {
				$query = $this->pdo->prepare("SELECT * FROM $this->table ORDER BY $sortby");
			}
			else {
				$query = $this->pdo->prepare("SELECT * FROM $this->table");
			}
			
			$query->execute();
			$array = $query->fetchAll();
			
			return $array;
		}
		catch(PDOException $e) {
			return null;
		}
	}
	
	public function select($idName, $id) {
		try {
			$query = $this->pdo->prepare("SELECT * FROM $this->table WHERE $idName = :id");
			$query->execute(array("id" => $id));
			$row = $query->fetch();
			
			return $row;
		}
		catch(PDOException $e) {
			return null;
		}
	}
	
	public function delete($idName, $id) {
		try {
			$query = $this->pdo->prepare("DELETE FROM $this->table WHERE $idName = :id");
			$query->execute(array("id" => $id));
			
			if($query->rowCount() > 0) {
				return 1;
			}
			
			return 0;
		}
		catch(PDOException $e) {
			return null;
		}
	}
	
	public function runSelectQuery($sql, $params = array()) {
		try {
			$query = $this->pdo->prepare($sql);
			$query->execute($params);
			
			if($array = $query->fetchAll()) {
				return $array;
			}
			
			return null;
		}
		catch(PDOException $e) {
			return null;
		}
	}
	
	public function runQuery($sql, $params) {
		try{
			$query = $this->pdo->prepare($sql);
			$query->execute($params);
			
			if($id = $this->pdo->lastInsertId()) {
				return $id;
			}
			else if($query->rowCount() > 0) {
				return 1;
			}
			// else if($query->rowCount() === 0) {
				// return -1;
			// }
			
			return null;
		}
		catch(PDOException $e) {
			// echo "error: ".$e->getMessage();
			// exit("pdo error");
			return null;
		}
	}
	
	public function update($field, $value, $wField = 1, $wValue = 1, $table = null) {
		try {
			if($table) {
				$query = $this->pdo->prepare("UPDATE $table SET $field = :v1 WHERE $wField = :v2");
			}
			else {
				$query = $this->pdo->prepare("UPDATE $this->table SET $field = :v1 WHERE $wField = :v2");
			}
			
			$params = array("v1" => $value, "v2" => $wValue);
			$query->execute($params);
			
			if($query->rowCount() > 0) {
				return 1;
			}
			//else if($query->rowCount() === 0) {
			//	return -1;
			//}

			return null;
		}
		catch(PDOException $e) {
			return null;
		}
	}
}
?>