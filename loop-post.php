<?php if(have_posts()) : ?>
	<ul class="list-posts">
		<?php while(have_posts()) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
				<article>
					<header class="post-header">
						<p class="meta"><?php echo get_the_date(); ?> - <?php echo get_post_meta($post->ID, 'publisher', true); ?></p>
						<h2><a href="#story=post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
					</header>
				</article>
			</li>
		<?php endwhile; ?>
	</ul>
<?php endif; ?>