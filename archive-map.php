<?php get_header(); ?>

<section id="content">
	<div id="map-archive" class="gray-page archive-page">
		<div class="limiter">

			<div class="clearfix">
				<?php get_search_form(); ?>

				<?php if(have_posts()) : ?>

					<section id="maps" class="map-loop-section archive-list">
						<h1><?php _e('Maps', 'infoamazonia'); ?></h1>
						<?php get_template_part('loop', 'maps'); ?>
					</section>

				<?php endif; ?>

				<?php if(is_active_sidebar('main-sidebar')) : ?>
					<aside class="page-sidebar">
						<ul class="widgets">
							<?php dynamic_sidebar('main-sidebar'); ?>
						</ul>
					</aside>
				<?php endif; ?>
			</div>

			<?php get_template_part('section', 'submit-call'); ?>

		</div>
	</div>
</section>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>