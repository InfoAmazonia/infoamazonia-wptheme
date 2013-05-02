<?php get_header(); ?>

<?php if(have_posts()) : the_post(); ?>

	<section id="stage">
		<div class="limiter clearfix">
			<?php get_template_part('section', 'subheader'); ?>
			<div id="main-map" class="stage-map">
				<?php mappress_map(); ?>
			</div>
		</div>
	</section>

	<section id="content">
		<div class="limiter">

			<?php // get_template_part('section', 'publisher-description'); ?>

			<?php // get_template_part('section', 'submit-call'); ?>

		</div>
	</section>
<?php endif; ?>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>