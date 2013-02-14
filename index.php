<?php get_header(); ?>

<section id="stage">
	<div class="limiter">

		<?php get_template_part('section', 'subheader'); ?>

		<?php
		// Display latest (featured) map group
		query_posts('post_type=map-group&posts_per_page=1');
			if(have_posts()) : ?>
				<?php
				while(have_posts()) : the_post();
					get_template_part('content', 'map-group');
				endwhile;
				?>
		<?php
		endif;
		wp_reset_query();
		?>
	</div>
</section>

<section id="content">
	<div class="limiter">
		<?php get_template_part('loop'); ?>
	</div>
</section>

<?php get_footer(); ?>