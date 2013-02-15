<div id="main-map" class="stage-map">
	<?php
	while(have_posts()) : the_post();
		get_template_part('content', get_post_type());
	endwhile;
	?>
</div>