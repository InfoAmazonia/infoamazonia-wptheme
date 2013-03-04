<div class="clearfix">
	<ul class="list-maps clearfix">
		<?php while(have_posts()) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item clearfix'); ?>>
				<article>
					<?php if(has_post_thumbnail()) {
						the_post_thumbnail('map-thumb');
					} else {
						get_template_part('content', 'map');
					} ?>
					<header class="post-header">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					</header>
					<section>
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="button"><?php _e('View this map', 'infoamazonia'); ?></a>
					</section>
				</article>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
</div>