<div class="eight columns">
	<ul class="list-datasets">
		<?php while(have_posts()) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item row'); ?>>
				<article class="clearfix">
					<?php
					if(has_post_thumbnail()) {
						echo '<a href="' . get_permalink() .'" title="' . get_the_title() . '">' . get_the_post_thumbnail($post->ID, 'map-thumb') . '</a>';
					}
					?>
					<header class="post-header">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					</header>
					<section>
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="button"><?php _e('View this data', 'infoamazonia'); ?></a>
						<?php
						$data = get_field('full_download');
						if($data) :
							?>
							<a href="<?php echo $data; ?>" class="button download"><?php _e('Download', 'infoamazonia'); ?></a>
							<?php
						endif;
						?>
						<?php
						$data = get_field('source_url');
						if($data) :
							?>
							<a href="<?php echo $data; ?>" class="button download"><?php _e('Download from source', 'infoamazonia'); ?></a>
							<?php
						endif;
						?>
					</section>
				</article>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
</div>
