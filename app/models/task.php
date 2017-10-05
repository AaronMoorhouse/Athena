<?php
require_once("lib/model.php");

class Task extends Model {
	
	/*
	* Get tasks of a specific team.
	*/
	public function getTeamTasks($id) {
		$this->connect();
		$sql = file_get_contents("app/webroot/sql/get_team_tasks.sql");
		$params = array("id" => $id);
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Get tasks assigned to a specific user.
	*/
	public function getUserTasks($id) {
		$this->connect();
		$sql = file_get_contents("app/webroot/sql/get_user_tasks.sql");
		$params = array("id" => $id);
		$result = $this->runSelectQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Get data of a specific task.
	*/
	public function getTask($id) {
		$this->connect();
		$result = $this->select('task_id', $id);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Add a new task to database.
	*/
	public function addTask($teamId, $userId, $task, $start, $end) {
		$this->connect();
		$sql = "INSERT INTO $this->table(team_id, user_id, task_name, start_date, end_date) VALUES(:team, :user, :task, :start, :end)";
		$params = array("team" => $teamId, "user" => $userId, "task" => $task, "start" => $start, "end" => $end);
		$result = $this->runQuery($sql, $params);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Update info of a specific task in database.
	*/
	public function updateTask($taskId, $userId, $task, $start, $end) {
		$this->connect();
		$this->update('task_name', $task, 'task_id', $taskId);
		$this->update('user_id', $userId, 'task_id', $taskId);
		$this->update('start_date', $start, 'task_id', $taskId);
		$this->update('end_date', $end, 'task_id', $taskId);
		$this->disconnect();
		
		return 1;
	}
	
	/*
	* Update completion status of a specific task.
	*/
	public function setComplete($id, $complete) {
		$this->connect();
		$result = $this->update('completed', $complete, 'task_id', $id);
		$this->disconnect();
		
		return $result;
	}
	
	/*
	* Delete a task from the database.
	*/
	public function deleteTask($id) {
		$this->connect();
		$result = $this->delete("task_id", $id);
		$this->disconnect();
		
		return $result;
	}
}
?>