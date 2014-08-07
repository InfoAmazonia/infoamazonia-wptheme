<?php get_header(); ?>

<section id="content">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<div id="page" class="gray-page">
		<div class="container row">
			<div class="eight columns">
				<article id="post-<?php the_ID(); ?>" <?php post_class('main'); ?>>
						<header class="page-header">
							<h1><?php the_title(); ?></h1>
							<div class="meta">
								<p class="author"><span class="lsf">&#xE137;</span> <?php _e('by', 'infoamazonia'); ?> <?php the_author(); ?></p>
								<p class="date"><span class="lsf">&#xE15e;</span> <?php echo get_the_date(); ?></p>
								<?php the_terms($post->ID, 'blog-category', '<p class="categories"><span class="lsf">&#xE128;</span>', ', ', '</p>'); ?>
							</div>
						</header>
						<section class="post-content">
							<?php the_content(); ?>
						</section>
				</article>
				<?php comments_template(); ?>
			</div>
		</div>
	</div>
<?php endwhile; endif; ?>
</section>

<?php get_footer(); ?>