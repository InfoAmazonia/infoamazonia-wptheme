<div class="eight columns">
	<ul class="list-blog-posts">
		<?php while(have_posts()) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item row'); ?>>
				<article class="clearfix">
					<header class="post-header">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="meta">
							<p class="author"><span class="lsf">&#xE137;</span> <?php _e('by', 'infoamazonia'); ?> <?php the_author(); ?></p>
							<p class="date"><span class="lsf">&#xE15e;</span> <?php echo get_the_date(); ?></p>
							<?php the_terms($post->ID, 'blog-category', '<p class="categories"><span class="lsf">&#xE128;</span>', ', ', '</p>'); ?>
						</div>
						<?php
						if(has_post_thumbnail()) {
							echo '<a href="' . get_permalink() .'" title="' . get_the_title() . '">' . get_the_post_thumbnail($post->ID, 'large') . '</a>';
						}
						?>
					</header>
					<aside class="social clearfix">
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="verdana"></div>
						<div class="twitter-button">
							<a href="https://twitter.com/share" class="twitter-share-button" data-via="infoamazonia" <?php if(function_exists('qtranxf_getLanguage')) : ?>data-lang="<?php echo qtranxf_getLanguage(); ?>"<?php endif; ?>>Tweet</a>
						</div>
					</aside>
					<section>
						<?php the_excerpt(); ?>
						<p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Continue lendo...</a></p>
					</section>
				</article>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
</div>
