<?php echo '<script>setActiveLink("'.$activeLink.'");</script>'; ?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div id="content">
	<?php
		//Breadcrumbs
		echo '<ul class="breadcrumbs">';
		echo '<li><a href="./">Home</a></li>';
		echo '<li><a href="./teams">Teams</a></li>';
		echo '<li><a href="./tasks/view/'.$team['team_id'].'">'.$team['team_name'].'</a></li>';
		echo '<li>Manage</li>';
		echo '</ul>';
		
		$memberIds = array();
		echo '<h1>'.$team['team_name'].'</h1>';
		echo '<p>Manage your team by adding/removing members and managing admin statuses.</p>';
		
		//echo '<h2>Edit Team Name</h2>';
		echo '<form action="./teams/editTeamName/'.$team['team_id'].'" method="post">';
		echo '<label class="formlabel" for="team_name">Team Name:</label>';
		echo '<input class="formfield field" name="team_name" value="'.$team['team_name'].'"></br></br>';
		echo '<input class="button" type="submit" value="Submit"></form>';
		
		echo '<h2>Members</h2>';
		
		if(count($members) > 0) {
			echo '<form id="remove_form" action="./teams/removeMember/'.$team['team_id'].'" method="post">';
			echo '<input id="user" type="hidden" name="user" value=""></form>';
			echo '<form id="admin_form" action="./teams/setAdmin/'.$team['team_id'].'" method="post">';
			echo '<input id="selected" type="hidden" name="selected" value="">';
			echo '<input id="status" type="hidden" name="status" value=""></form>';
			echo '<table id="member_table">';
			echo '<tr><th>Name</th><th>Status</th><th>Remove</th></tr>';
			
			foreach($members as $member) {
				echo '<tr><td>'.$member['first_name'].' '.$member['surname'].'</td>';
				echo '<td>';
				
				if($member['admin_status'] == 1) {
					echo '<span style="color: red">Admin</span></br>(<a href="javascript: setAdmin('.$member['user_id'].', \'0\')">Revoke</a>)</td>';
				}
				else {
					echo 'Team Member</br>(<a href="javascript: setAdmin('.$member['user_id'].', \'1\')">Set admin</a>)</td>';
				}
				
				echo '<td><a href="javascript: remove('.$member['user_id'].')">Remove</a></td></tr>';
				array_push($memberIds, $member['user_id']);
			}
			
			echo '</table>';
		}
		else {
			echo '<p><i>No team members found</i></p>';
		}
		?>
		
		<h2 id="add">Add Team Member</h2>
		<p>Search for users below to add them to your team.</p>
		<form action="teams/searchUsers/" method="post">
			<label class="formlabel" for="member_search">Search Users:</label>
			<input id="member_search" class="formfield field" name="search" required></br></br>
			<input class="button" type="submit" value="Search">
		</form>
		
		<?php
		if(isset($users[0])) {
			echo '<h3>Results</h3>';
			
			if(count($users[1]) > 0) {
				echo '<form action="./teams/addMembers/'.$team['team_id'].'" method="post">';
				echo '<table id="member_table" style="width: 40%">';
				
				foreach($users[1] as $user) {
					echo '<tr><td><input type="checkbox" name="members[]" value="'.$user['user_id'].'"'; 
					
					if(in_array($user['user_id'], $memberIds)) {
						echo ' disabled checked';
					}
					
					echo '></td>';
					echo '<td>'.$user['first_name'].' '.$user['surname'].'</td></tr>';
				}
				
				echo '</table>';
				echo '<input class="button" type="submit" value="Submit"></form></br>';
			}
			else {
				echo '<p style="color: red">No users found.</p>';
			}
		}
		else {
			echo '</br>';
		}
	?>
	
	<h2>Email Notification</h2>
	<p>Enter a message in the editor below to send an email notification to all team members.</br>
		<span style="color: red"><i>Emails may only be received by users registered with a unimail/staffmail address.</i></span>
	</p>
	<form <?php echo 'action="./teams/sendEmail/'.$team['team_id'].'"'; ?> method="post">
		<label class="formlabel" for="subject">Subject:</label>
		<input class="formfield field" name="subject" required></br></br>
		<label class="formlabel" for="content">Body:</label>
		<textarea id="editor" class="mceEditor" name="content" required></textarea>
	</form>
	</br>
</div>
<script>
	function remove(user) {
		$("#user").val(user);
		$("#remove_form").submit();
	}
	
	function setAdmin(user, value) {
		$("#selected").val(user);
		$("#status").val(value);
		$("#admin_form").submit();
	}
</script>
<script>
	window.tinymce.dom.Event.domLoaded = true;
	
	tinymce.init({
		selector: 'textarea',
		plugins: [
			'advlist autolink autoresize lists link image charmap preview hr',
			'searchreplace wordcount visualblocks code fullscreen spellchecker',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons paste textcolor colorpicker textpattern imagetools'
		],
		toolbar1: 'save insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent visualblocks',
		toolbar2: 'link image preview media | forecolor backcolor | spellchecker code insertdatetime emoticons',
		menubar: 'edit insert format table tools',
		image_advtab: true,
		browser_spellcheck: true,
	});
</script>