<?php get_header(); ?>

<section id="content">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<div id="page" class="gray-page">
		<div class="limiter">
			<div class="clearfix">
				<article id="post-<?php the_ID(); ?>" <?php post_class('main'); ?>>
						<header>
							<h1><?php the_title(); ?></h1>
						</header>
						<section class="post-content">
							<?php the_content(); ?>
						</section>
				</article>
			</div>

			<?php get_template_part('section', 'submit-call'); ?>

		</div>
	</div>
<?php endwhile; endif; ?>
</section>

<?php get_footer(); ?>