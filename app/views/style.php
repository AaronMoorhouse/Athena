<style>
	#top, #footer, #mobile-menu, #mobile-menu li a, .button, .task_table th, #member_table th {
		background-color: <?php echo $colour; ?>
	}
	
	h1, h2, h3, .breadcrumbs li a {
		color: <?php echo $colour; ?>
	}
	
	.task_table td, .task_table th, #member_table td, #member_table th {
		border: 1px solid <?php echo $colour; ?>
	}
	
	.task, .field, .largefield, .select {
		border-color: <?php echo $colour; ?>
	}
	
	<?php
		if($lightness > 130) {
			$hover = $col->editShade(0.9);
			$active = $col->editShade(0.8);
			
			echo "#menu li a, #mobile-menu li a, #top p a, #footer p, .button, .task_table th { color: black; }";
			
			if($lightness > 180) {
				$linkHover = "#888888";
				echo "#menu a:hover, #mobile-menu a:hover { color: $linkHover; }";
			}
		}
		else {
			echo "#mobile-menu li { border-bottom: 1px solid #A0A0A0; }";
			
			$hover = $col->editTint(0.1);
			$active = $col->editTint(0.2);
		}
		
		$rgb1 = $col->editTint(0.9);
		$rgb2 = $col->editTint(0.6);
		$rgb3 = $col->editTint(0.75);
		
		$breadcrumbHover = $col->editShade(0.8);
		$breadcrumbBg = $col->editTint(0.8);
		
		echo ".button:hover { background-color: $hover} .button:active { background-color: $active; }";
		echo ".formfield:focus, input[type=\"checkbox\"] {  outline-color: $colour; }";
		echo ".breadcrumbs li a:hover { color: $breadcrumbHover; } .breadcrumbs { background-color: $breadcrumbBg; }";
		echo "body { background: linear-gradient(135deg, rgb(255,255,255) 0%,$rgb1 40%,$rgb2 100%) no-repeat center center fixed; }";
		echo ".task_table tr:hover, #member_table tr:hover { background-color: $rgb3; }";
		echo "@media screen and (max-width : 1000px) { .wrapper { background: linear-gradient(135deg, rgb(255,255,255) 0%,$rgb1 35%,$rgb2 100%) no-repeat center center fixed; }}";
	?>
</style>