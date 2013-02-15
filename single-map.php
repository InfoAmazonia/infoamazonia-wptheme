<?php get_header(); ?>

<section id="stage">
	<div class="limiter clearfix">
		<?php if(have_posts()) : ?>
			<h1 class="title"><?php the_title(); ?></h1>
			<?php get_template_part('stage', 'map'); ?>
		<?php endif; ?>
	</div>
</section>

<section id="content">
	<div class="limiter">

		<?php
		$query = mappress_get_marker_query_args(8);
		query_posts($query);
		if(have_posts()) : ?>

			<section id="last-stories" class="loop-section">
				<h3><?php _e('Stories', 'infoamazonia'); ?></h3>
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