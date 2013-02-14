<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="limiter">
			<header>
				<h1><?php the_title(); ?></h1>
			</header>
			<section class="post-content">
				<?php the_content(); ?>
			</section>
		</div>
	</article>
<?php endwhile; endif; ?>

<?php get_footer(); ?>