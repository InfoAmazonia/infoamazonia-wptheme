<div class="eight columns">
	<ul class="list-blog-posts">
		<?php while(have_posts()) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item row'); ?>>
				<article class="clearfix">
					<header class="post-header">
						<?php the_terms($post->ID, 'blog-category', '<p class="meta">', ', ', '</p>'); ?>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="author"><?php _e('by', 'infoamazonia'); ?> <?php the_author(); ?></p>
						<?php
						if(has_post_thumbnail()) {
							echo '<a href="' . get_permalink() .'" title="' . get_the_title() . '">' . get_the_post_thumbnail($post->ID, 'large') . '</a>';
						}
						?>
					</header>
					<section>
						<?php the_excerpt(); ?>
					</section>
				</article>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
</div>
