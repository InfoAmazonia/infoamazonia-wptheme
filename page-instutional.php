<?php
/*
 * Template Name: Institutional
 */
?>

<?php get_header(); ?>

<?php
// Slider
$slider_query = new WP_Query(array('post_type' => 'slider', 'posts_per_page' => 4));
if($slider_query->have_posts()) :
	$first_img = wp_get_attachment_image_src(get_post_thumbnail_id($slider_query->post->ID));
	?>
	<section id="slider" style="background-image: url(<?php echo $first_img[0]; ?>);">
		<div class="slider-content">
			<?php while($slider_query->have_posts()) :
				$slider_query->the_post();
				$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-image="<?php echo $image[0]; ?>">
					<div class="container">
						<div class="five columns">
							<header class="post-header">
								<h2><?php the_title(); ?></h2>
							</header>
							<section class="post-content">
								<?php the_content(); ?>
							</section>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<aside id="participate">
			<div class="container">
				<div class="twelve columns">
					<div class="participate-content">
						<h2>Citizen participation</h2>
						<h3>Take action on amazon water issues!</h3>
						<a class="button" href="http://agua.infoamazonia.org/">Submit a report</a>
					</div>
				</div>
			</div>
		</aside>
	</section>
	<?php
endif;
?>


<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>