<?php echo '<script>setActiveLink("'.$activeLink.'");</script>'; ?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div id="content">
	<?php
		//Breadcrumbs
		echo '<ul class="breadcrumbs">';
		echo '<li><a href="./">Home</a></li>';
		
		if($disc['disc_type'] == "Team") {
			echo '<li><a href="./teams">Teams</a></li>';
			echo '<li><a href="./tasks/view/'.$team['team_id'].'">'.$team['team_name'].'</a></li>';
			echo '<li><a href="./discussions/team/'.$team['team_id'].'">Team Discussions</a></li>';
		}
		else {
			echo '<li><a href="./discussions">Discussions</a></li>';
		}
		
		echo '<li>'.$disc['subject'].'</li>';
		echo '</ul>';
		
		echo "<h1>".$disc['subject']."</h1>";
		
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $disc['created']);
		$created = $date->format('l jS F Y, h:i A');
		
		echo "<p>Discussion started by ".$disc['first_name']." ".$disc['surname']." on  ".$created."</p>";
	?>
	<button id="new_button" class="button" onclick="toggle()">Create Post</button>
	<br/>
	<div id="new_post_form">
		<br/>
		<form <?php echo 'action="./discussions/addPost/'.$disc['discussion_id'].'"'; ?> method="post">
			<textarea id="editor" class="mceEditor" name="post"></textarea>
		</form>
	</div>
	<?php
		if(count($posts) > 0) {
			$count = 0;
			
			foreach($posts as $post) {
				$bgCol = new Colour($post['colour']);
				$tint = $bgCol->editTint(0.6);
				
				echo '<div class="post" style="background-color: '.$tint.';';
				
				if($count == 0) {
					echo ' margin: 20px 0 20px 0;';
				}
				
				echo '">';
				echo '<div class="post_header">';
				
				$date = DateTime::createFromFormat('Y-m-d H:i:s', $post['posted']);
				$posted = $date->format('D jS M Y, h:i A');
				
				echo '<div class="post_time">';
				echo '<p>'.$posted.'</p>';
				echo '</div>';
				echo '<div class="post_name">';
				echo '<p>'.$post['first_name'].' '.$post['surname'].'</p></div></div>';
				echo '<div class="post_content">';
				echo '<p>'.$post['content'].'</p>';
				echo '</div></div>';
				
				$count++;
			}
		}
		else {
			echo '<p><i>There are no posts in this discussion</i></p>';
		}
		
		echo '</br><a href="javascript:void(0)" onclick="window.scrollTo(0, 0)">Return to top</a><br/><br/>';
	?>
</div>
<script>
	var form = document.getElementById('new_post_form');
	var newButton = document.getElementById('new_button');
	var visible = false;
	
	function toggle() {
		if(!visible) {
			form.style.display = "block";
			newButton.innerHTML = "Cancel";
			visible = true;
		}
		else {
			form.style.display = "none";
			newButton.innerHTML = "Create Post";
			visible = false;
		}
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