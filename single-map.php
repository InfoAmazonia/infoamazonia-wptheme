<?php get_header(); ?>

<section id="stage">
	<div class="limiter clearfix">
		<ul class="share">
			<li class="facebook">
				<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="verdana" data-action="recommend"></div>
			</li>
			<li class="twitter">
				<a href="https://twitter.com/share" class="twitter-share-button" data-via="InfoAmazonia" data-lang="<?php if(function_exists('qtrans_getLanguage')) echo qtrans_getLanguage(); ?>">Tweet</a>
			</li>
			<li class="share">
				<a class="button share-button" href="<?php echo infoamazonia_get_share_url(array('map_id' => $post->ID)); ?>"><?php _e('Embed this map', 'infoamazonia'); ?></a>
			</li>
		</ul>
		<h1 class="title"><?php the_title(); ?></h1>
		<?php get_template_part('stage', 'map'); ?>
	</div>
</section>

<section id="content">
	<div class="limiter">

		<?php
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$query = array(
			'paged' => $paged,
			's' => isset($_GET['s']) ? $_GET['s'] : null
		);
		query_posts($query);
		if(have_posts()) : ?>
		
			<?php get_search_form(); ?>

			<section id="last-stories" class="loop-section">
				<h3><?php _e('Stories on', 'infoamazonia'); ?> &ldquo;<?php the_title(); ?>&ldquo;</h3>
				<?php get_template_part('loop'); ?>
			</section>

		<?php
		endif;
		wp_reset_query(); ?>

		<?php get_template_part('section', 'submit-call'); ?>

	</div>
</section>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>