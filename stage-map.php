<?php while(have_posts()) : the_post(); ?>
	<div id="main-map" <?php post_class('stage-map'); ?>>
		<?php get_template_part('content', get_post_type()); ?>
	</div>
<?php endwhile; ?>