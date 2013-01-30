<?php get_header(); ?>

<section id="content">
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
	<?php
	query_posts('post_type=map');
	if(have_posts()) : while(have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="map-header">
				<h2><?php the_title(); ?></h2>
			</header>
			<section class="map-content">
				<?php get_map(); ?>
			</section>
		</article>
	<?php endwhile; endif; ?>

</section>

<?php get_footer(); ?>