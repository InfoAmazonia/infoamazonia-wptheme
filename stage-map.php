<?php while(have_posts()) : the_post(); ?>
	<div id="main-map" <?php post_class('stage-map'); ?>>
		<?php jeo_map(); ?>
	</div>
<?php endwhile; ?>