<?php get_header(); ?>

<section id="stage">
	<div class="limiter clearfix">
		<h1 class="title"><?php the_title(); ?></h1>
		<?php get_template_part('stage', 'map'); ?>
	</div>
</section>

<section id="content">
	<div class="limiter">

		<?php
		query_posts(mappress_marker_get_query_vars());
		if(have_posts()) : ?>

			<section id="last-stories" class="loop-section">
				<h3><?php _e('Stories on', 'infoamazonia'); ?> &ldquo;<?php the_title(); ?>&ldquo;</h3>
				<?php get_template_part('loop'); ?>
			</section>

		<?php
		endif;
		wp_reset_query(); ?>

		<?php get_template_part('section', 'submit-call'); ?>

	</div>
</section>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>