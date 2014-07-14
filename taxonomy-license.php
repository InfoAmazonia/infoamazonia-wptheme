<?php get_header(); ?>

<section id="content">
	<div id="map-archive" class="gray-page archive-page">
		<?php if(have_posts()) : ?>

			<section id="datasets" class="dataset-loop-section archive-list">
				<div class="page-header">
					<div class="container">
						<div class="twelve columns">
							<h2><a href="<?php echo get_post_type_archive_link('dataset'); ?>"><?php _e('Datasets', 'infoamazonia'); ?></a></h2>
							<h1><?php single_term_title(); ?></h1>
							<?php
							$term = get_queried_object();
							if($term->description) :
								?>
								<p><?php echo $term->description; ?></p>
								<?php
							endif;
							$url = get_field('url', $term->taxonomy . '_' . $term->term_id);
							if($url) :
								?>
								<a target="_blank" href="<?php echo $url; ?>">Read more</a>
								<?php
							endif;
							?>
						</div>
					</div>
				</div>

				<div class="container">
					<?php get_template_part('loop', 'dataset'); ?>

					<div class="four columns">
						<div class="row sources sidebar-item">
							<h3><?php _e('Sources', 'infoamazonia'); ?></h3>
							<ul>
								<?php wp_list_categories(array(
									'taxonomy' => 'source',
									'title_li' => ''
								)); ?>
							</ul> 
						</div>

						<div class="row sources sidebar-item">
							<h3><?php _e('Licenses', 'infoamazonia'); ?></h3>
							<ul>
								<?php wp_list_categories(array(
									'taxonomy' => 'license',
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