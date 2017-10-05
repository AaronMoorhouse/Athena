<?php echo '<script>setActiveLink("'.$activeLink.'");</script>'; ?>
<script src="app/webroot/js/row_click.js"></script>
<div id="content">
	<ul class="breadcrumbs">
		<li>Home</li>
	</ul>
	<?php
		echo '<h1>Welcome, '.$_SESSION['user']['first_name'].'</h1>';
		echo '<p>Welcome! Below you will find all of the tasks you have been assigned to complete and also any discussions you are currently participating in.<br/>';
		echo 'Also, if you don\'t like the colour scheme, change it via the settings menu (click your name on the menu bar).</p>';
		echo '<h2>Outstanding Tasks</h2>';
		
		if(count($tasks) > 0) {
			$statuses = array(array("In Progress", "orange"), array("Overdue", "red"));
		
			echo '<table id="user_task_table" class="task_table">';
			echo '<tr><th>Task</th><th>Team</th><th>Start</th><th>End</th><th>Status</th></tr>';
			
			foreach($tasks as $task) {
				if($task['completed'] == 1) {
					continue;
				}
				else {
					if(date("Y-m-d") <= $task['end_date']) {
						$status = 0;
					}
					else {
						$status = 1;
					}
				}
				
				$startDate = DateTime::createFromFormat("Y-m-d", $task['start_date']);
				$endDate = DateTime::createFromFormat("Y-m-d", $task['end_date']);
				$start = $startDate->format("d/m/y");
				$end = $endDate->format("d/m/y");
				
				echo '<tr><td>'.$task['task_name'].'</td><td><a class="hidden_link" href="./tasks/view/'.$task['team_id'].'">'.$task['team_name'].'</a></td><td>'.$start.'</td><td>'.$end.'</td>';
				echo '<td><span style="color: '.$statuses[$status][1].'">'.$statuses[$status][0].'</span></td></tr>';
			}
			
			echo '</table>';
		}
		else {
			echo '<p><i>You currently have no tasks to complete.</br><a href="./teams">View my teams</a></i></p>';
		}
		
		echo '<h2>Ongoing Discussions</h2>';
		
		if(count($discs) > 0) {
			echo '<p>Discussions you are currently involved in.</p>';
			
			$general = array();
			$team = array();
			
			foreach($discs as $disc) {
				if($disc['disc_type'] == "Team") {
					array_push($team, $disc);
				}
				else {
					array_push($general, $disc);
				}
			}
			
			if(count($general) > 0) {
				echo '<h3>General</h3>';
				
				foreach($general as $disc) {
					$bgCol = new Colour($disc['colour']);
					$tint = $bgCol->editTint(0.6);
					
					$date = DateTime::createFromFormat('Y-m-d H:i:s', $disc['created']);
					$created = $date->format('D jS M Y, h:i A');
					
					echo '<a href="./discussions/view/'.$disc['discussion_id'].'">';
					echo '<div class="discussion" style="background-color: '.$tint.'">';
					echo '<div class="discussion_header">';
					echo '<p class="discussion_subject"><strong><i>'.$disc['subject'].'</i></strong></p>';
					echo '</div>';
					echo '<div class="discussion_content">';
					
					if(isset($posts[$disc['discussion_id']]['content'])) {
						echo '<p>'.$posts[$disc['discussion_id']]['content'].'</p>';
					}
					else {
						echo '<p><i>There are no posts in this discussion</i></p>';
					}
					
					echo '</div>';
					echo '<div class="discussion_footer">';
					echo '<p class="post_count">Total posts: '.$postCounts[$disc['discussion_id']].'</p>';
					echo '<p>Started by: '.$disc['first_name'].' '.$disc['surname'].'</br>'.$created.'</p>';
					echo '</div></div></a>';
				}
			}
			
			if(count($team) > 0) {
				echo '<h3>Team</h3>';
				
				foreach($team as $disc) {
					$bgCol = new Colour($disc['colour']);
					$tint = $bgCol->editTint(0.6);
					
					$date = DateTime::createFromFormat('Y-m-d H:i:s', $disc['created']);
					$created = $date->format('D jS M Y, h:i A');
					
					echo '<a href="./discussions/view/'.$disc['discussion_id'].'">';
					echo '<div class="discussion" style="background-color: '.$tint.'">';
					echo '<div class="discussion_header">';
					echo '<p class="discussion_subject"><strong><i>'.$disc['subject'].'</i></strong></p>';
					echo '</div>';
					echo '<div class="discussion_content">';
					
					if(isset($posts[$disc['discussion_id']]['content'])) {
						echo '<p>'.$posts[$disc['discussion_id']]['content'].'</p>';
					}
					
					echo '</div>';
					echo '<div class="discussion_footer">';
					echo '<p class="post_count">Total posts: '.$postCounts[$disc['discussion_id']].'</p>';
					echo '<p>Started by: '.$disc['first_name'].' '.$disc['surname'].'</br>'.$created.'</p>';
					echo '</div></div></a>';
				}
			}
		}
		else {
			echo '<p>You are not currently involved in any ongoing public/team discussions.</br><a href="./discussions">Get involved</a></p>';
		}
	?>
</div>