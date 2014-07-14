<?php get_header(); ?>

<section id="content">
	<div id="map-archive" class="gray-page archive-page">
		<?php if(have_posts()) : ?>

			<section id="datasets" class="dataset-loop-section archive-list">
				<div class="page-header">
					<div class="container">
						<div class="twelve columns">
							<h1><?php _e('Datasets', 'infoamazonia'); ?></h1>
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

						<div class="row licenses sidebar-item">
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