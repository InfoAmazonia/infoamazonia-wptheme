<?php get_header(); ?>

<section id="stage">
	<div class="limiter">
		<?php $mapgroup = array_shift(get_posts('post_type=map-group&posts_per_page=1')); ?>
		<?php mappress_mapgroup($mapgroup->ID); ?>
	</div>
</section>

<section id="content">
	<div class="limiter">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="post-header">
					<h2><?php the_title(); ?></h2>
				</header>
				<section class="post-content">
					<?php the_content(); ?>
				</section>
			</article>
		<?php endwhile; endif; ?>
	</div>
</section>

<?php get_footer(); ?>