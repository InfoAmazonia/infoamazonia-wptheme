<?php
$sticky = new WP_Query(array(
	'posts_per_page' => 4,
	'post__in' => get_option('sticky_posts'),
	'ignore_sticky_posts' => 1
));
if($sticky->have_posts()) :
	?>
	<div class="sticky-posts">
		<?php while($sticky->have_posts()) : $sticky->the_post(); ?>
			<div class="sticky-item" data-postid="<?php the_ID(); ?>">
				<article id="sticky-post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="post-area">
						<header class="post-header">
							<?php if(has_post_thumbnail()) : ?>
								<div class="post-thumbnail">
									<?php the_post_thumbnail('thumbnail'); ?>
								</div>
							<?php endif; ?>
							<h2><?php the_title(); ?></h2>
						</header>
						<section class="post-content">
							<?php the_excerpt(); ?>
						</section>
					</div>
					<footer class="post-actions">
						<a class="button" href="<?php the_permalink(); ?>"><?php _e('Read more', 'infoamazonia'); ?></a>
						<a class="button share-button" href="<?php echo jeo_get_share_url(array('p' => get_the_ID())); ?>"><?php _e('Share', 'infoamazonia'); ?></a>
					</footer>
				</article>
			</div>
		<?php endwhile; ?>
	</div>
<?php
endif;
?>
