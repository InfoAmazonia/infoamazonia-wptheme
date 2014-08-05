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
	$first_img = wp_get_attachment_image_src(get_post_thumbnail_id($slider_query->post->ID), 'full');
	?>
	<section id="slider">
		<div class="slider-content" style="background-image: url(<?php echo $first_img[0]; ?>);">
			<?php while($slider_query->have_posts()) :
				$slider_query->the_post();
				$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-image="<?php echo $image[0]; ?>">
					<div class="container">
						<div class="five columns">
							<header class="post-header">
								<h2><a href="<?php the_field('slider_url'); ?>"><?php the_title(); ?></a></h2>
							</header>
							<section class="post-content">
								<?php the_content(); ?>
							</section>
						</div>
					</div>
					<a class="selector" href="#" data-item="post-<?php the_ID(); ?>">&nbsp;</a>
				</article>
			<?php endwhile; ?>
		</div>
		<nav id="slider-nav">
			<div class="container">
				<div class="five columns">
					<div class="slider-nav-content">
					</div>
				</div>
			</div>
		</nav>
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

<section id="about">
	<div id="data_block" class="about-block right clearfix">
		<div class="container">
			<div class="four columns">
				<svg id="svg_data" version="1.1" viewBox="0 0 100 100">
					<g>
						<rect class="h-bar-1" fill-opacity=".7" width="37.807999" height="4" x="44.882" y="47.958" />
						<rect class="h-bar-2" fill-opacity=".7" width="37.807999" height="4" x="44.882" y="54.528999" />
						<rect class="h-bar-3" fill-opacity=".7" width="37.807999" height="4" x="44.882" y="61.805" />
						<rect class="v-bar v-bar-1" fill-opacity=".7" width="3.546" height="22.013" x="79.144997" y="15.918" />
						<rect class="v-bar v-bar-2" fill-opacity=".7" width="3.546" height="13.493" x="71.156998" y="24.438" />
						<rect class="v-bar v-bar-3" fill-opacity=".7" width="3.546" height="5.5050001" x="63.168999" y="32.425999" />
						<path class="chart part-1" fill="#84bff6" d="M46.806,16.112v10.01h10.008C56.309,20.812,52.115,16.624,46.806,16.112z"/>
						<path class="chart part-2" fill="#f68484" d="M56.814,28.253H46.271l-7.566,7.564c1.926,1.572,4.354,2.555,7.036,2.555C51.553,38.372,56.273,33.924,56.814,28.253z"/>
						<path class="chart part-3" fill="#eff684" d="M44.675,16.112c-5.671,0.544-10.117,5.265-10.117,11.075c0,2.728,1.013,5.193,2.634,7.134l7.483-7.486V16.112z"/>
						<path class="data-container" fill="#fff" d="M85.586,5H31.63c-4.502,0-8.169,3.667-8.169,8.169v37.813c0.031,0,0.059-0.004,0.09-0.004c0.495,0,0.982,0.031,1.466,0.074   c-0.484-0.04-0.971-0.074-1.466-0.074c-9.558,0-17.308,7.748-17.308,17.307c0,9.559,7.75,17.308,17.308,17.308   c0.494,0,0.979-0.033,1.462-0.074c-0.482,0.044-0.968,0.074-1.462,0.074c-0.031,0-0.059-0.004-0.09-0.004v1.242   c0,4.503,3.667,8.169,8.169,8.169h38.339c1.777,0,3.45-0.662,5.275-2.194c1.826-1.533,14.866-14.862,16.198-16.509   c1.961-2.421,2.314-3.841,2.314-6.148V13.169C93.757,8.667,90.093,5,85.586,5z M26.362,51.227   c-0.259-0.043-0.517-0.089-0.779-0.119C25.845,51.14,26.104,51.183,26.362,51.227z M19.95,77.19l-7.446-7.446l4.518-4.518   l3.024,3.024l10.431-9.997l4.424,4.614L19.95,77.19z M25.587,85.463c0.246-0.029,0.488-0.072,0.731-0.111   C26.076,85.392,25.833,85.432,25.587,85.463z M31.63,90.74c-2.155,0-3.909-1.754-3.909-3.909v-1.765   c-0.006,0.001-0.012,0.002-0.017,0.004c7.549-1.863,13.154-8.661,13.154-16.785c0-8.129-5.61-14.929-13.165-16.787   c0.009,0.002,0.019,0.004,0.028,0.006V13.169c0-2.155,1.753-3.909,3.909-3.909h53.956c2.157,0,3.909,1.753,3.909,3.909   l0.018,58.235c-0.097,0.406-0.431,1.016-0.938,1.766h-10.08c-3.333,0-6.04,2.704-6.04,6.038v10.538   c-0.722,0.521-1.312,0.87-1.721,0.994H31.63z"/>
					</g>
				</svg>
			</div>
			<div class="eight columns">
				<div class="block-text">
					<h2><?php _e('Data and analysis', 'infoamazonia'); ?></h2>
					<p>12 GB of updated datasets on the most pressuring issues of the Amazon rainforest. All data available for download. Get graphical analysis through maps and charts.</p>
				</div>
			</div>
		</div>
	</div>
	<div id="map_block" class="about-block bigger-block left clearfix">
		<div class="container">
			<div class="five columns">
				<div class="block-text">
					<h2><?php _e('Map design', 'infoamazonia'); ?></h2>
					<p>More than 30 layers of georeferenced data ready to be used on interactive maps. Make your own visualization with our tool and get the embed code to publish customized maps</p>
				</div>
			</div>
			<div class="seven columns">
				<?php include(STYLESHEETPATH . '/img/map_data_design.svg'); ?>
			</div>
		</div>
	</div>
	<div id="network_block" class="about-block right clearfix">
		<div class="container">
			<div class="four columns">
				<svg version="1.1" viewBox="0 0 100 100">
					<g>
						<path id="i0" d="M94.466,0.5H18.958c-2.78,0-5.034,2.254-5.034,5.034v75.508c0,2.78,2.254,5.034,5.034,5.034h75.508    c2.78,0,5.034-2.254,5.034-5.034V5.534C99.5,2.754,97.246,0.5,94.466,0.5z M94.466,81.042H18.958V5.534h75.508V81.042z"/>
						<rect x="23.992" y="10.568" width="25.169" height="25.169"/>
						<rect x="54.195" y="10.568" width="35.237" height="5.034"/>
						<rect x="54.195" y="20.636" width="35.237" height="5.034"/>
						<rect x="54.195" y="30.704" width="35.237" height="5.034"/>
						<rect x="23.992" y="40.771" width="65" height="5.034"/>
						<rect x="23.992" y="50.839" width="65" height="5.034"/>
						<rect x="23.992" y="60.907" width="65" height="5.033"/>
					</g>
				</svg>
			</div>
			<div class="eight columns">
				<div class="block-text">
					<h2><?php _e('Journalists and<br/>citizen network', 'infoamazonia'); ?></h2>
					<p>Get news from a network of journalist which expands through 9 countries and read first hand reports of citizens and NGOs sent directly from the cities, forests and rivers of the Amazon</p>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="map-gallery" class="row">
	<header>
		<h2><?php _e('Map gallery', 'infoamazonia'); ?></h2>
		<h3></h3>
		<a class="share"><?php _e('Embed this map', 'infoamazonia'); ?></a>
		<nav>
			<a class="prev-map lsf" href="#" title="Mapa anterior">&#xE080;</a>
			<a class="next-map lsf" href="#" title="Próximo mapa">&#xE112;</a>
		</nav>
	</header>
	<?php get_template_part('content', 'map-group'); ?>
	<script type="text/javascript">
		(function($) {

			var maps = [];

			var baseUrl = '<?php echo jeo_get_share_url(); ?>';

			jeo.groupReady(function(group) {
				maps = _.keys(group.mapsData);

				$('#map-gallery .next-map').click(function() {

					var current = group.map.conf.id;

					var currentIndex = _.indexOf(maps, current);

					var toGo = maps[currentIndex+1] || maps[0];

					group.update(toGo);
					group.updateUI();

					return false;

				});

				$('#map-gallery .prev-map').click(function() {

					var current = group.map.conf.id;

					var currentIndex = _.indexOf(maps, current);

					var toGo = maps[currentIndex-1] || maps[maps.length-1];

					group.update(toGo);
					group.updateUI();

					return false;

				});

			});

			var updateHeader = function(group) {
				jQuery('#map-gallery header h3').text(group.map.conf.title);
				jQuery('#map-gallery header .share').attr('href', baseUrl + 'map_id=' + group.map.conf.id);
			};

			jeo.groupReady(updateHeader);
			jeo.groupChanged(updateHeader);

		})(jQuery);
	</script>
</section>

<?php
query_posts('post_type=project');
?>
<section id="projects" class="row">
	<div class="container">
		<div class="twelve columns">
			<header class="section-header">
				<h2><?php _e('Special projects', 'infoamazonia'); ?></h2>
			</header>
		</div>
		<?php get_template_part('loop', 'projects'); ?>
	</div>
</section>
<?php
wp_reset_query();
?>

<?php get_template_part('section', 'main-widget'); ?>

<?php get_footer(); ?>