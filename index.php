<?php get_header(); ?>

<section id="content">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
			<?php echo get_post_meta($post->ID, 'algum_meta_dado', true); ?>
		</article>
	<?php endwhile; endif; ?>
</section>

<?php get_footer(); ?>