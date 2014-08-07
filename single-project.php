<?php get_header(); ?>

<section id="content">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<div id="page" class="gray-page">
		<div class="container row">
			<div class="eight columns">
				<article id="post-<?php the_ID(); ?>" <?php post_class('main'); ?>>
						<header class="page-header">
							<h1><?php the_title(); ?></h1>
						</header>
						<section class="post-content">
							<?php the_content(); ?>
							<a href="<?php the_field('project_url'); ?>" title="<?php the_title(); ?>" rel="external" target="_blank" class="button"><?php _e('View this project', 'infoamazonia'); ?></a>
						</section>
				</article>
			</div>
		</div>
	</div>
<?php endwhile; endif; ?>
</section>

<?php get_footer(); ?>