<div class="clearfix">
	<ul class="list-posts clearfix">
		<?php while(have_posts()) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
				<article>
					<header class="post-header">
						<p class="meta">
							<?php echo get_the_date(_x('m/d/Y', 'reduced date format', 'infoamazonia')); ?> - 
							<?php echo array_shift(get_the_terms($post->ID, 'publisher'))->name; ?></p>
						<div class="media-limit">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php
								if(has_post_thumbnail())
									the_post_thumbnail('post-thumb');
								else
									echo '<img src="' . get_post_meta($post->ID, 'picture', true) . '" />';
								?>
							</a>
						</div>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					</header>
				</article>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
</div>