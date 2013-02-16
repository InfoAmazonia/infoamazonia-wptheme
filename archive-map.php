<?php get_header(); ?>

<section id="content">
	<div id="map-archive" class="gray-page">
		<div class="limiter">

			<?php get_search_form(); ?>

			<?php if(have_posts()) : ?>

				<section id="maps" class="map-loop-section">
					<h1><?php _e('Maps', 'infoamazonia'); ?></h1>
					<?php get_template_part('loop', 'maps'); ?>
				</section>

			<?php endif; ?>

			<?php get_template_part('section', 'submit-call'); ?>

		</div>
	</div>
</section>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>