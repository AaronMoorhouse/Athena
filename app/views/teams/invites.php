<?php echo '<script>setActiveLink("'.$activeLink.'");</script>'; ?>
<div id="content">
	<ul class="breadcrumbs">
		<li><a href="./">Home</a></li>
		<li><a href="./teams">Teams</a></li>
		<li>Team Invites</li>
	</ul>
	<h1>Team Invites</h1>
	<p>Invitations to join teams will appear here. Click 'Accept' to join the team or click 'Reject' to ignore the invite.</p>
	<?php
		echo '<form id="form" action="./teams/respond" method="post">';
		echo '<input id="invite" type="hidden" name="invite">';
		echo '<input id="response" type="hidden" name="response">';
		echo '</form>';
	
		if(count($invites) > 0) {
			foreach($invites as $invite) {
				echo '<div style="margin-bottom: 10px">';
				echo '<h2 style="margin-bottom: 0">'.$invite['team_name'].'</h2>';
				
				//Members
				if(count($members[$invite['team_id']]) > 0) {
					echo '<span class="members" >Members: ';
					$count = 0;
					
					foreach($members[$invite['team_id']] as $member) {
						if($count > 0) {
							echo ', ';
						}
						
						echo $member['first_name'].' '.$member['surname'];
						$count++;
					}
					
					echo '</span>';
				}
				
				echo '</br></br><button onclick="respond('.$invite['invite_id'].', 1)" class="button smallbutton" style="margin: 0 20px 10px 0">Accept</button>';
				echo '<button onclick="respond('.$invite['invite_id'].', 0)" class="button smallbutton">Reject</button>';
				echo '</div>';
			}
		}
		else {
			echo '<p><strong><i>You currently have no team invites.</i></strong></p>';
		}
	?>
</div>
<script>
	var form = document.getElementById("form");
	var invite = document.getElementById("invite");
	var response = document.getElementById("response");
	
	function respond(inv, resp) {
		invite.value = inv
		response.value = resp;
		
		form.submit();
	}
</script>