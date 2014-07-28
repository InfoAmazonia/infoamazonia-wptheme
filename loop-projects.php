<ul class="list-projects clearfix">
	<?php while(have_posts()) : the_post(); ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class('post-item six columns'); ?>>
			<article class="clearfix">
				<?php if(has_post_thumbnail()) {
					echo '<a href="' . get_permalink() .'" title="' . get_the_title() . '">' . get_the_post_thumbnail($post->ID, 'project-thumb') . '</a>';
				} ?>
				<header class="post-header">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="button"><?php _e('View this project', 'infoamazonia'); ?></a>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</header>
				<section>
					<?php the_excerpt(); ?>
				</section>
			</article>
		</li>
	<?php endwhile; ?>
</ul>
<div class="twelve columns">
	<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
</div>