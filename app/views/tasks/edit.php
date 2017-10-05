<?php echo '<script>setActiveLink("'.$activeLink.'");</script>'; ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div id="content">
	<?php
		//Breadcrumbs
		echo '<ul class="breadcrumbs">';
		echo '<li><a href="./">Home</a></li>';
		echo '<li><a href="./teams">Teams</a></li>';
		echo '<li><a href="./tasks/view/'.$team['team_id'].'">'.$team['team_name'].'</a></li>';
		echo '<li>'.$task['task_name'].'</li>';
		echo '</ul>';
	?>
	<h1>Edit Task</h1>
	<form id="edit_form" <?php echo 'action="./tasks/update/'.$task['task_id'].'"'; ?> method="post">
			<label class="formlabel" for="task">Task:</label>
			<input class="formfield field" name="task" <?php if(isset($task['task_name'])) echo 'value="'.$task['task_name'].'"'; ?> required>
			<label class="formlabel" for="task">User:</label>
			<select class="formfield select" name="user" required>
				<?php
					foreach($members as $member) {
						echo '<option value="'.$member['user_id'].'"';
						
						if($member['user_id'] == $task['user_id']) {
							echo ' selected';
						}
						
						echo '>'.$member['first_name'].' '.$member['surname'].'</option>';
					}
					
					$startDate = DateTime::createFromFormat("Y-m-d", $task['start_date']);
					$endDate = DateTime::createFromFormat("Y-m-d", $task['end_date']);
					$start = $startDate->format("m/d/Y");
					$end = $endDate->format("m/d/Y");
				?>
			</select>
			<label class="formlabel" for="task">Start Date:</label>
			<input id="datepicker" class="formfield field" name="start" <?php echo 'value="'.$start.'"'; ?> required>
			<label class="formlabel" for="task">End Date:</label>
			<input id="datepicker2" class="formfield field" name="end" <?php echo 'value="'.$end.'"'; ?> required></br></br>
			<input class="button" type="submit" value="Submit"></br></br>
		</form>
</div>
<script>
	$(function() {
		$("#datepicker").datepicker();
		$("#datepicker2").datepicker();
	});
</script>