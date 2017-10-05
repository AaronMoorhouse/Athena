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
		echo '<li>Team Discussions</li>';
		echo '</ul>';
		
		echo '<h1>Team Discussions | '.$team['team_name'].'</h1>';
	?>
	<p>Private team discussion threads are hosted here. You can start a new discussion or view and participate in ongoing discussions with other team members.</p>
	<button id="new_button" class="button" onclick="toggle()">Start New</button>
	<br/>
	<div id="new_disc_form">
		<br/>
		<form action="./discussions/addDisc/<?php echo $team['team_id']; ?>" method="post">
			<label class="formlabel" for="disc_subject">Discussion Subject:</label>
			<input id="disc_subject" class="field formfield" type="text" name="subject">
			<br/><br/>
			<label class="formlabel" for="editor">Post:</label>
			<textarea id="editor" class="mceEditor" name="post"></textarea>
		</form>
	</div>
	<?php
		if(count($discs) > 0) {
			echo '<h2>Discussions</h2>';
			echo '<p>Click on a discussion below to join in the conversation:</p>';
			
			for($i = 0; $i < count($discs); $i++) {
				$bgCol = new Colour($discs[$i]['colour']);
				$tint = $bgCol->editTint(0.6);
				
				$date = DateTime::createFromFormat('Y-m-d H:i:s', $discs[$i]['created']);
				$created = $date->format('D jS M Y, h:i A');
				
				echo '<a href="./discussions/view/'.$discs[$i]['discussion_id'].'">';
				echo '<div class="discussion" style="background-color: '.$tint.'">';
				echo '<div class="discussion_header">';
				echo '<p class="discussion_subject"><strong><i>'.$discs[$i]['subject'].'</i></strong></p>';
				echo '</div>';
				echo '<div class="discussion_content">';
				
				if(isset($posts[$i]['content'])) {
					echo '<p>'.$posts[$i]['content'].'</p>';
				}
				
				echo '</div>';
				echo '<div class="discussion_footer">';
				echo '<p class="post_count">Total posts: '.$postCounts[$i].'</p>';
				echo '<p>Started by: '.$discs[$i]['first_name'].' '.$discs[$i]['surname'].'</br>'.$created.'</p>';
				echo '</div></div></a>';
			}
		}
		else {
			echo '<p><i>There are currently no ongoing discussions</i></p>';
		}
	?>
</div>
<script>
	var form = document.getElementById('new_disc_form');
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
			newButton.innerHTML = "Start New";
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