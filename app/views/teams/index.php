<?php echo '<script>setActiveLink("'.$activeLink.'");</script>'; ?>
<div id="content">
	<ul class="breadcrumbs">
		<li><a href="./">Home</a></li>
		<li>Teams</li>
	</ul>
	<h1>My Teams</h1>
	<p>All the teams that you are currently a member of are displayed below. Click on a team to view/manage the group's tasks or create a new team by clicking the button below.</p>
	<button id="new_team_button" class="button" onclick="toggleForm()">Create Team</button>
	<a class="button" href="./teams/invites" style="text-decoration: none; margin-left: 10px">View Team Invites<?php if($invites > 0) echo " ($invites)"; ?></a></br>
	<div id="new_team_form" style="display: none">
		</br>
		<form action="./teams/addTeam" method="post">
			<label class="formlabel" for="team_name">Team Name:</label></br>
			<input class="formfield field" name="team_name"></br></br>
			<input class="button" type="submit" value="Submit">
		</form>
	</div>			
	<?php
		if(count($teams) > 0) {
			foreach($teams as $team) {
				echo '<div class="team">';
				echo '<p><a href="./tasks/view/'.$team['team_id'].'" style="color: #0000FF">'.$team['team_name'].'</a>';
				
				if(count($members[$team['team_id']]) > 0) {
					echo '</br><span class="members">Members: ';
					$count = 0;
					
					foreach($members[$team['team_id']] as $member) {
						if($count > 0) {
							echo ', ';
						}
						
						echo $member['first_name'].' '.$member['surname'];
						$count++;
					}
				}
				
				echo '</span></p></div>';
			}
		}
		else {
			echo '<p><i>You are not currently a member of any teams.</i></p>';
		}
	?>
</div>
<script>
	var form = document.getElementById('new_team_form');
	var button = document.getElementById('new_team_button');
	
	function toggleForm() {
		if(form.style.display == "none") {
			form.style.display = "block";
			button.innerHTML = "Cancel";
		}
		else {
			form.style.display = "none";
			button.innerHTML = "Create Team";
		}
	}
</script>