<?php get_header(); ?>

<section id="stage">
	<div class="container">
		<div class="twelve columns">
			<?php get_template_part('section', 'subheader'); ?>
			<div id="main-map" class="stage-map">
				<?php jeo_featured(); ?>
			</div>
		</div>
	</div>
</section>

<section id="content">

	<?php get_template_part('section', 'publisher-description'); ?>

	<div class="container">
		<div class="twelve columns">
			<?php get_search_form(); ?>
		</div>
	</div>

	<?php if(is_front_page() && !is_paged()) : ?>

		<?php query_posts(array('meta_key' => 'featured', 'posts_per_page' => 4)); if(have_posts()) : ?>

			<div class="container">

				<section id="highlights" class="loop-section">
					<div class="twelve columns">
						<h3><?php _e('Highlights', 'infoamazonia'); ?></h3>
					</div>
					<?php get_template_part('loop'); ?>
				</section>

			</div>

		<?php endif; wp_reset_query(); ?>

	<?php endif; ?>

	<?php if(have_posts()) : ?>

		<div class="container">

			<section id="last-stories" class="loop-section">
				<div class="twelve columns">
					<?php if(is_front_page()) : ?>
						<h3><?php _e('Last stories', 'infoamazonia'); ?></h3>
					<?php elseif(is_tax('publisher')) : ?>
						<h3><?php _e('Stories by ', 'infoamazonia'); ?> &ldquo;<?php single_term_title(); ?>&rdquo;</h3>
					<?php elseif(is_tag()) : ?>
						<h3><?php _e('Stories on ', 'infoamazonia'); ?> &ldquo;<?php single_tag_title(); ?>&rdquo;</h3>
					<?php else : ?>
						<h3><?php _e('Stories', 'infoamazonia'); ?></h3>
					<?php endif; ?>
				</div>
				<?php get_template_part('loop'); ?>
			</section>

		</div>

	<?php else : ?>

		<?php query_posts('post_type=post'); if(have_posts()) : ?>

			<div class="container">

				<section id="last-stories" class="loop-section">
					<div class="six columns">
						<h3><?php _e('Nothing found. Viewing all posts', 'infoamazonia'); ?></h3>
					</div>
					<?php get_template_part('loop'); ?>
				</section>

			</div>

		<?php endif; wp_reset_query(); ?>

	<?php endif; ?>

	<?php get_template_part('section', 'submit-call'); ?>

</section>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>