<?php get_header(); ?>

<?php if(have_posts()) : the_post(); ?>

	<article class="single-post">
		<section id="stage" class="row">
			<div class="container">
				<div class="nine columns">
					<header class="post-header">
						<?php echo get_the_term_list($post->ID, 'publisher', '', ', ', ''); ?>
						<h1 class="title"><?php the_title(); ?></h1>
					</header>
					<?php if(jeo_has_marker_location()) : ?>
						<!-- <div id="main-map" class="stage-map">
							<?php // jeo_map(); ?>
						</div> -->
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section id="content">
			<div class="container row">
				<div class="nine columns">
					<div class="post-primary-image">
						<?php if(has_post_thumbnail()) the_post_thumbnail(); ?>
					</div>
				</div>
			</div>
			<div class="container row">
				<div class="two columns">
					<div class="post-interactivity">
						<p class="buttons">
							<a class="button" href="<?php echo get_post_meta($post->ID, 'url', true); ?>" target="_blank">
								<span class="lsf">&#xE046;</span>
								<?php _e('Original article', 'infoamazonia'); ?>
							</a>
							<a class="button embed-button" href="<?php echo jeo_get_share_url(array('p' => $post->ID)); ?>" target="_blank">
								<span class="lsf">&#xE118;</span>
								<?php _e('Embed this story', 'infoamazonia'); ?>
							</a>
							<a class="button print-button" href="<?php echo jeo_get_embed_url(array('p' => $post->ID)); ?>" target="_blank">
								<span class="lsf">&#xE10a;</span>
								<?php _e('Print', 'infoamazonia'); ?>
							</a>
						</p>
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="verdana" data-action="recommend"></div>
						<div class="twitter-button">
							<a href="https://twitter.com/share" class="twitter-share-button" data-via="infoamazonia" <?php if(function_exists('qtrans_getLanguage')) : ?>data-lang="<?php echo qtrans_getLanguage(); ?>"<?php endif; ?>>Tweet</a>
						</div>
					</div>
				</div>
				<div class="seven columns">
					<div class="post-content">
						<div class="post-description">
							<p class="date"><strong><?php echo get_the_date(); ?></strong></p>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
					<div class="three columns">
						<div class="post-sidebar">
							<?php if(function_exists('yarpp_related')) : ?>
								<div class="post-related row">
									<?php yarpp_related();?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<script type="text/javascript">
					var embedUrl = jQuery('.embed-button').attr('href');
					var printUrl = jQuery('.print-button').attr('href');
					jeo.mapReady(function(map) {
						if(map.conf.postID) {
							jQuery('.print-button').attr('href', printUrl + '&map_id=' + map.conf.postID + '#print');
							jQuery('.embed-button').attr('href', embedUrl + '&map_id=' + map.conf.postID);
						}
					});
					jeo.groupReady(function(group) {
						jQuery('.print-button').attr('href', printUrl + '&map_id=' + group.currentMapID + '#print');
						jeo.groupChanged(function(group, prevMap) {
							jQuery('.print-button').attr('href', printUrl + '&map_id=' + group.currentMapID + '#print');
						});
					});
				</script>

			</div>
		</section>
	</article>
<?php endif; ?>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>
