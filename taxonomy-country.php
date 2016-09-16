<?php get_header(); ?>

<?php
	global $projects;
	if ($projects) {
		get_template_part('content', 'projects');
	} else {
?>

<section id="stage" class="with-bg">
	<?php
	$term = get_queried_object();
	$bg_image = get_field('header_image', $term);
	// print_r(get_post($bg_image));
	?>
	<div class="image-header" style="background-image:url(<?php echo get_post($bg_image)->guid; ?>);">
		<div class="container">
			<div class="twelve columns">
	      <div class="sub-header clearfix" >
	        <h1 class="title"><?php single_cat_title(); ?></h1>
	      </div>
				<?php //get_template_part('section', 'subheader'); ?>
			</div>
		</div>
	</div>
	<?php if(!get_query_var('infoamazonia_advanced_nav')) : ?>
		<div id="main-map" class="stage-map">
			<?php jeo_featured(); ?>
		</div>
	<?php endif; ?>
</section>

<section id="content">


	<?php if(have_posts()) : ?>

		<section id="country-stories" class="timeline-section">
			<div class="container">
				<div class="twelve columns">
					<ul class="timeline-items">
						<?php while(have_posts()) : the_post(); ?>
							<li class="timeline-item clearfix">
								<article>
									<div class="post-box">
										<header class="post-header">
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
												<?php
												if(has_post_thumbnail())
													the_post_thumbnail('post-thumb');
												else
													echo '<img src="' . get_post_meta($post->ID, 'picture', true) . '" />';
												?>
											</a>
											<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
											<p class="meta clearfix">
												<?php
												if(get_the_terms($post->ID, 'publisher')) :
													?>
													<span class="publisher">
														<span class="lsf">clip</span>
														<span class="publisher-content">
															<?php
															echo array_shift(get_the_terms($post->ID, 'publisher'))->name;
															?>
														</span>
													</span>
													<?php
												endif;
												?>
											</p>
										</header>
										<section class="post-content">
											<?php the_excerpt(); ?>
										</section>
										<footer class="post-actions">
											<div class="buttons">
												<a class="button" href="<?php the_permalink(); ?>"><?php _e('Read more', 'infoamazonia'); ?></a>
												<a class="button" href="<?php echo jeo_get_share_url(array('p' => $post->ID)); ?>"><?php _e('Share', 'infoamazonia'); ?></a>
											</div>
										</footer>
									</div>
									<aside class="post-date">
										<?php if(is_new_day()) : ?>
											<p class="date"><?php the_date(_x('m/d/Y', 'reduced date format', 'infoamazonia')); ?></p>
										<?php endif; ?>
										<p class="time"><?php the_time(); ?></p>
									</aside>
								</article>
							</li>
						<?php endwhile; ?>
					</ul>
					<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
				</div>
			</div>
		</section>

	<?php endif; ?>

</section>

<?php
	}
?>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>
