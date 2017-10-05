<?php echo '<script>setActiveLink("'.$activeLink.'");</script>'; ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="app/webroot/js/jsgantt.js"></script>
<link rel="stylesheet" type="text/css" href="app/webroot/css/jsgantt.css" />
<div id="content">
	<?php
		//Breadcrumbs
		echo '<ul class="breadcrumbs">';
		echo '<li><a href="./">Home</a></li>';
		echo '<li><a href="./teams">Teams</a></li>';
		echo '<li>'.$team['team_name'].'</li>';
		echo '</ul>';
		
		echo '<h1>'.$team['team_name'].'</h1>';
		echo '<p>Members: ';
		$colours = array();
		$classes = array();
		
		for($i = 0; $i < count($members); $i++) {
			echo $members[$i]['first_name'] . ' ' . $members[$i]['surname'];
			
			if($members[$i]['admin_status'] == 1) {
				echo ' <span style="color: red">[Admin]</span>';
				
				if($members[$i]['user_id'] == $_SESSION['user']['user_id']) {
					$isAdmin = 1;
				}
			}
			
			if($i != count($members) - 1) {
				echo ', ';
			}
			
			if(!in_array($members[$i]['colour'], $colours)) {
				$colours[$members[$i]['user_id']] = $members[$i]['colour'];
			}
		}
		
		foreach($colours as $user => $colour) {
			$class = '.taskCol'.$user.' { background: '.$colour.'; height: 13px; filter: alpha(opacity=90); opacity:0.9; margin-top: 1px; }';
			$classes[$user] = $class;
		}
		
		if(isset($isAdmin)) {
			echo ' (<a href="./teams/manage/'.$team['team_id'].'">Manage</a>)';
		}
		
		echo '<p><a href="./discussions/team/'.$team['team_id'].'">View Team Discussions</a></p>';
		?>
		
		<h2>Tasks</h2>
		<button id="add_button" class="button" onclick="toggleAddForm()">Add Task</button></br></br>
		<form id="add_form" style="display: none;" <?php echo 'action="./tasks/add/'.$team['team_id'].'"'; ?> method="post">
			<label class="formlabel" for="task">Task:</label>
			<input class="formfield field" name="task" required>
			<label class="formlabel" for="task">Person Responsible:</label>
			<select class="formfield select" name="user" required>
				<?php
					foreach($members as $member) {
						echo '<option value="'.$member['user_id'].'">'.$member['first_name'].' '.$member['surname'].'</option>';
					}
				?>
			</select>
			<label class="formlabel" for="task">Start Date:</label>
			<input id="datepicker" class="formfield field" name="start" required>
			<label  class="formlabel" for="task">End Date:</label>
			<input id="datepicker2" class="formfield field" name="end" required></br></br>
			<input class="button" type="submit" value="Submit"></br></br>
		</form>
		
		<?php
		$lastEnd = null;
		if(count($tasks) > 0) {
			$statuses = array(array("Completed", "green"), array("In Progress", "orange"), array("Overdue", "red"));
			$firstStart = $tasks[0]['start_date'];
			$lastEnd = $tasks[0]['end_date'];
			$allComplete = true;
			
			echo '<form id="task_form" action="./tasks/markComplete" method="post">';
			echo '<input type="hidden" id="tsk" name="tsk" value="">';
			echo '<input type="hidden" id="comp" name="comp" value="">';
			echo '</form>';
			
			echo '<form id="delete_form" action="tasks/remove" method="post">';
			echo '<input type="hidden" id="del" name="del" value="">';
			echo '</form>';
			
			echo '<table class="task_table mobile_table"><tr>';
			echo '<th>Complete</th><th>Task</th><th>User</th><th>Start</th><th>End</th><th>Status</th><th>Edit</th><th>Delete</th></tr>';
			
			//Desktop view
			foreach($tasks as $task) {
				if($task['completed'] == 1) {
					$status = 0;
				}
				else {
					if(date("Y-m-d") <= $task['end_date']) {
						$status = 1;
					}
					else {
						$status = 2;
					}
				}
				
				if($task['end_date'] > $lastEnd) {
					$lastEnd = $task['end_date'];
				}
				
				if($allComplete == true && $task['completed'] == 0) {
					$allComplete = false;
				}
				
				$startDate = DateTime::createFromFormat("Y-m-d", $task['start_date']);
				$endDate = DateTime::createFromFormat("Y-m-d", $task['end_date']);
				$start = $startDate->format("d/m/y");
				$end = $endDate->format("d/m/y");
				
				$name = $task['first_name'] . ' ' . $task['surname'];
				
				echo '<tr><td><input class="check" type="checkbox" value="'.$task['task_id'].'"';
				
				if($task['completed'] == 1) {
					echo ' checked';
				}
				
				echo '></td><td>'.$task['task_name'].'</td><td>'.$name.'</td><td>'.$start.'</td><td>'.$end.'</td><td>';
				echo '<span style="color: '.$statuses[$status][1].'">'.$statuses[$status][0].'</span></td>'; 
				echo '<td><a href="./tasks/edit/'.$task['task_id'].'">Edit</a></td><td><a href="javascript: remove(\''.$task['task_id'].'\')">Delete</a></td>';
			}
			
			echo '</table>';
			
			//Mobile view
			foreach($tasks as $task) {
				if($task['completed'] == 1) {
					$status = 0;
				}
				else {
					if(date("Y-m-d") <= $task['end_date']) {
						$status = 1;
					}
					else {
						$status = 2;
					}
				}
				
				$startDate = DateTime::createFromFormat("Y-m-d", $task['start_date']);
				$endDate = DateTime::createFromFormat("Y-m-d", $task['end_date']);
				$start = $startDate->format("d/m/y");
				$end = $endDate->format("d/m/y");
				
				$name = $task['first_name'] . ' ' . $task['surname'];
				
				echo '<div class="task" style="border-color: '.$statuses[$status][1].'">';
				echo '<input class="check" type="checkbox" value="'.$task['task_id'].'"';
				
				if($task['completed'] == 1) {
					echo ' checked';
				}
				
				echo '><p class="task_name"><strong>'.$task['task_name'].'</strong></p>';
				echo '<p class="task_info">User: '.$name.'</br>Start: '.$start.'</br>End: '.$end;
				echo '</br>Status: <span style="color: '.$statuses[$status][1].'">'.$statuses[$status][0].'</span>';
				echo '</br></br><a href="./tasks/edit/'.$task['task_id'].'">Edit</a> | <a href="javascript: remove(\''.$task['task_id'].'\')">Delete</a>';
				echo '</p></div>';
			}
			
			echo '<h2>Gantt Chart</h2>';
			echo '<p id="show-gantt"><a href="javascript: toggleGantt()">Show Gantt Chart</a></p>';
			echo '<div id="gantt_chart_container" style="display: none; overflow-x: auto;"><div id="GanttChartDIV" class="gantt" style="position: relative;"></div></br></div>';
		}
		else {
			echo '<p><i>There are no tasks currently set.</i></p>';
		}
	?>
</div>
<script>
	$(function() {
		$("#datepicker").datepicker();
		$("#datepicker2").datepicker();
	});
</script>
<script>
	var addForm = document.getElementById('add_form');
	var addButton = document.getElementById('add_button');
	var gantt = document.getElementById('gantt_chart_container');
	var show = document.getElementById('show-gantt');
	
	function toggleAddForm() {
		if(addForm.style.display == "none") {
			addForm.style.display = "block";
			addButton.innerHTML = "Cancel";
		}
		else {
			addForm.style.display = "none";
			addButton.innerHTML = "Add Task";
		}
	}
	
	function toggleGantt() {
		if(gantt.style.display == "none") {
			gantt.style.display = "block";
			show.childNodes[0].innerHTML = "Hide Gantt Chart";
		}
		else {
			gantt.style.display = "none";
			show.childNodes[0].innerHTML = "Show Gantt Chart";
		}
	}
</script>
<script>	
	$(function() {
		$(".check").change(
			function() {
				if($(this).is(":checked")) {
					$("#comp").val("1");
				}
				else {
					$("#comp").val("0");
				}
				
				$("#tsk").val($(this).val());
				$("#task_form").submit();
			}
		)
	});
	
	function remove(task) {
		$("#del").val(task);
		$("#delete_form").submit();
	}
</script>
<script>
	var g;
	
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		g = new JSGantt.GanttChart(document.getElementById('GanttChartDIV'), 'week');
	}
	else {
		g = new JSGantt.GanttChart(document.getElementById('GanttChartDIV'), 'day');
	}
	
	if(g.getDivId() != null) {
		g.setShowRes(1); // Show/Hide Responsible (0/1)
		g.setShowDur(1); // Show/Hide Duration (0/1)
		g.setShowComp(1); // Show/Hide % Complete(0/1)
		g.setCaptionType('Resource');  // Set to Show Caption (None,Caption,Resource,Duration,Complete)
		g.setShowStartDate(1); // Show/Hide Start Date(0/1)
		g.setShowEndDate(1); // Show/Hide End Date(0/1)
		//g.setDateTaskInputFormat('dd/mm/yyyy'); // Set format of input dates ('mm/dd/yyyy', 'dd/mm/yyyy', 'yyyy-mm-dd')
		g.setDateTaskDisplayFormat('dd/mm/yyyy'); // Set format to display dates ('mm/dd/yyyy', 'dd/mm/yyyy', 'yyyy-mm-dd')
		g.setFormatArr("day","week","month","quarter"); // Set format options (up to 4 : "minute","hour","day","week","month","quarter")
		g.setShowTaskInfoLink(1); // Show link in tool tip (0/1)
		g.setQuarterColWidth(36);
		
		g.setDateTaskDisplayFormat('day dd month yyyy'); // Shown in tool tip box
		g.setDayMajorDateDisplayFormat('mon yyyy - Week ww') // Set format to display dates in the "Major" header of the "Day" view
		g.setWeekMinorDateDisplayFormat('dd mon') // Set format to display dates in the "Minor" header of the "Week" view
		g.setShowTaskInfoLink(1); // Show link in tool tip (0/1)
		g.setShowEndWeekDate(0); // Show/Hide the date for the last day of the week in header for daily view (1/0)
		g.setUseSingleCell(10000); // Set the threshold at which we will only use one cell per table row (0 disables).  Helps with rendering performance for large charts.
		
		<?php
			if(count($tasks) > 0) {
				$startDate = DateTime::createFromFormat("Y-m-d", $firstStart);
				$endDate = DateTime::createFromFormat("Y-m-d", $lastEnd);
				$start = $startDate->format("d/m/y");
				$end = $endDate->format("d/m/y");
				$allComplete = $allComplete * 100;
				echo 'g.AddTaskItem(new JSGantt.TaskItem(99, "Project", "'.$start.'", "'.$end.'", "ggroupblack", "", 0, "Project", '.$allComplete.', 1, 0, 1));';
				
				echo 'var style = document.createElement("style"); style.type = "text/css";';
				
				foreach($classes as $class) {
					echo 'style.innerHTML += " '.$class.'";';
				}
				
				echo 'document.getElementsByTagName("head")[0].appendChild(style);';
			
				foreach($tasks as $task) {
					// $startDate = DateTime::createFromFormat("Y-m-d", $task['start_date']);
					// $endDate = DateTime::createFromFormat("Y-m-d", $task['end_date']);
					// $start = $startDate->format("d/m/y");
					// $end = $endDate->format("d/m/y");
					
					$comp = $task['completed'] * 100;
					$res = $task['first_name'].' '.$task['surname'];
					$taskCol = 'taskCol'.$task['user_id'];//ltrim($colours[$res], "#");
					//$taskCol = 'gtaskred';
					
					echo 'g.AddTaskItem(new JSGantt.TaskItem('.$task['task_id'] .', "'.$task['task_name'].'", "'.$task['start_date'].'", "'.$task['end_date'].'", "'.$taskCol.'", "", null, "'.$res.'", '.$comp.', null, 99));';
				}
				
				//g.AddTaskItem(new JSGantt.TaskItem(121, 'Constructor Proc',     '2017-02-21','2017-03-09', 'gtaskblue',    '',                 0, 'Brian T.', 60,    0,      12,      1,     '',      '',      '',      g));
			}
		?>
		
		g.Draw();
		g.DrawDependencies();
	}
</script>
