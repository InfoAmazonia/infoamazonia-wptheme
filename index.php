<?php get_header(); ?>

<?php
// Display latest (featured) map group
query_posts('post_type=map-group&posts_per_page=1');
if(have_posts()) : ?>
	<section id="stage">
		<div class="limiter">
			<?php
			while(have_posts()) : the_post();
				get_template_part('content', 'map-group');
			endwhile;
			?>
		</div>
	</section>
<?php
endif;
wp_reset_query();
?>

<section id="content">
	<div class="limiter">
		<?php get_template_part('loop', 'post'); ?>
	</div>
</section>

<?php get_footer(); ?>