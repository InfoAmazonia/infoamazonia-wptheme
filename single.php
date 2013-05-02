<?php get_header(); ?>

<?php if(have_posts()) : the_post(); ?>

	<article class="single-post">
		<section id="stage">
			<div class="limiter clearfix">
				<header class="post-header">
					<?php echo get_the_term_list($post->ID, 'publisher', '', ', ', ''); ?>
					<h1 class="title"><?php the_title(); ?></h1>
				</header>
				<div id="main-map" class="stage-map">
					<?php mappress_map(); ?>
				</div>
			</div>
		</section>

		<section id="content">
			<div class="limiter">
				<div class="post-content clearfix">
					<?php $thumbnail = infoamazonia_get_thumbnail(); ?>
						<div class="thumbnail">
							<?php if($thumbnail) : ?>
								<img src="<?php echo $thumbnail; ?>" />
							<?php endif; ?>
							<a class="button" href="<?php echo get_post_meta($post->ID, 'url', true); ?>" target="_blank"><?php _e('Go to the original article', 'infoamazonia'); ?></a>
							<p class="buttons">
								<a class="button embed-button" href="<?php echo infoamazonia_get_share_url(array('p' => $post->ID)); ?>" target="_blank"><?php _e('Embed this story', 'infoamazonia'); ?></a>
								<a class="button print-button" href="<?php echo mappress_get_embed_url(array('p' => $post->ID)); ?>" target="_blank"><?php _e('Print', 'infoamazonia'); ?></a>
							</p>
							<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="verdana" data-action="recommend"></div>
						</div>
					<div class="post-description">
						<?php the_content(); ?>
					</div>
				</div>

				<script type="text/javascript">
					var embedUrl = jQuery('.embed-button').attr('href');
					var printUrl = jQuery('.print-button').attr('href');
					mappress.mapReady(function(map) {
						if(map.conf.postID) {
							jQuery('.print-button').attr('href', printUrl + '&map_id=' + map.conf.postID + '#print');
							jQuery('.embed-button').attr('href', embedUrl + '&map_id=' + map.conf.postID);
						}
					});
					mappress.groupReady(function(group) {
						jQuery('.print-button').attr('href', printUrl + '&map_id=' + group.currentMapID + '#print');
						mappress.groupChanged(function(mapID) {
							jQuery('.print-button').attr('href', printUrl + '&map_id=' + mapID + '#print');
						});
					});
				</script>

			</div>
		</section>
	</article>
<?php endif; ?>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>