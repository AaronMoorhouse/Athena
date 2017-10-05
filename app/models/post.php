<?php
require_once("lib/model.php");

class Post extends Model {
	
	/*
	* Get posts in a specific discussion.
	*/
	public function getPosts($id, $limit = 999999) {
		$this->connect();
		$sql = file_get_contents("app/webroot/sql/get_posts.sql");
		$sql .= "\nLIMIT " . $limit;
		$params = array("id" => $id);
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Add a new post to a discussion.
	*/
	public function addPost($discId, $userId, $content) {
		$this->connect();
		$sql = "INSERT INTO $this->table (discussion_id, user_id, content, posted) VALUES (:disc, :user, :cont, :post)";
		$params = array("disc" => $discId, "user" => $userId, "cont" => $content, "post" => date("Y-m-d H:i:s"));
		$result = $this->runQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
}
?>