<section id="content">
	<div id="map-archive" class="gray-page archive-page">
		<div class="container">
				<?php if(have_posts()) : ?>

					<section id="maps" class="map-loop-section archive-list">
						<div class="twelve columns">
							<header class="page-header">
								<h1><?php _e('Projects', 'infoamazonia'); ?></h1>
							</header>
						</div>
						<?php get_template_part('loop', 'projects'); ?>
					</section>

				<?php endif; ?>
		</div>
	</div>
</section>
