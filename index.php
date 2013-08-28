<?php get_header(); ?>

<section id="stage">
	<div class="limiter clearfix">
		<?php get_template_part('section', 'subheader'); ?>
		<div id="main-map" class="stage-map">
			<?php jeo_featured(); ?>
		</div>
	</div>
</section>

<section id="content">
	<div class="limiter">

		<?php get_template_part('section', 'publisher-description'); ?>

		<?php get_search_form(); ?>

		<?php if(is_front_page() && !is_paged()) : ?>

			<?php query_posts(array('meta_key' => 'featured', 'posts_per_page' => 4)); if(have_posts()) : ?>

				<section id="highlights" class="loop-section">
					<h3><?php _e('Highlights', 'infoamazonia'); ?></h3>
					<?php get_template_part('loop'); ?>
				</section>

			<?php endif; wp_reset_query(); ?>

		<?php endif; ?>

		<?php if(have_posts()) : ?>

			<section id="last-stories" class="loop-section">
				<?php if(is_front_page()) : ?>
					<h3><?php _e('Last stories', 'infoamazonia'); ?></h3>
				<?php elseif(is_tax('publisher')) : ?>
					<h3><?php _e('Stories by ', 'infoamazonia'); ?> &ldquo;<?php single_term_title(); ?>&rdquo;</h3>
				<?php elseif(is_tag()) : ?>
					<h3><?php _e('Stories on ', 'infoamazonia'); ?> &ldquo;<?php single_tag_title(); ?>&rdquo;</h3>
				<?php else : ?>
					<h3><?php _e('Stories', 'infoamazonia'); ?></h3>
				<?php endif; ?>
				<?php get_template_part('loop'); ?>
			</section>

		<?php else : ?>

			<?php query_posts('post_type=post'); if(have_posts()) : ?>

				<section id="last-stories" class="loop-section">
					<h3><?php _e('Nothing found. Viewing all posts', 'infoamazonia'); ?></h3>
					<?php get_template_part('loop'); ?>
				</section>

			<?php endif; wp_reset_query(); ?>

		<?php endif; ?>

		<?php get_template_part('section', 'submit-call'); ?>

	</div>
</section>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>