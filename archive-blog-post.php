<?php get_header(); ?>

<section id="content">
	<div id="blog-archive" class="gray-page archive-page">
		<?php if(have_posts()) : ?>

			<section id="blog-posts" class="blog-loop-section archive-list">
				<div class="page-header">
					<div class="container">
						<div class="twelve columns">
							<h1><?php _e('Blog', 'infoamazonia'); ?></h1>
						</div>
					</div>
				</div>

				<div class="container">
					<?php get_template_part('loop', 'blog-post'); ?>

					<div class="four columns">

						<div class="row sources sidebar-item">
							<h3><?php _e('Categories', 'infoamazonia'); ?></h3>
							<ul>
								<?php wp_list_categories(array(
									'taxonomy' => 'blog-category',
									'title_li' => ''
								)); ?>
							</ul> 
						</div>
					</div>
				</div>
			</section>

		<?php endif; ?>
	</div>
</section>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>