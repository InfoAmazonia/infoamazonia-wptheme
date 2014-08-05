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
								<h2><a href="<?php the_field('slider_url'); ?>" target="_blank" rel="external" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
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
						<h2><?php _e('Citizen participation', 'infoamazonia'); ?></h2>
						<h3><?php _e('Take action on Amazon water issues!', 'infoamazonia'); ?></h3>
						<a class="button" href="http://agua.infoamazonia.org/"><?php _e('Submit a report', 'infoamazonia'); ?></a>
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
					<p><?php _e('12 GB of updated datasets on the most pressuring issues of the Amazon rainforest. All data available for download. Get graphical analysis through maps and charts.', 'infoamazonia'); ?></p>
				</div>
			</div>
		</div>
	</div>
	<div id="map_block" class="about-block bigger-block left clearfix">
		<div class="container">
			<div class="five columns">
				<div class="block-text">
					<h2><?php _e('Map design', 'infoamazonia'); ?></h2>
					<p><?php _e('More than 30 layers of georeferenced data ready to be used on interactive maps. Make your own visualization with our tool and get the embed code to publish customized maps', 'infoamazonia'); ?></p>
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
				<svg id="svg_network" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" xml:space="preserve">
					<g>
						<g class="circle">
							<path d="m 89.09465,48.971195 a 39.711933,39.711933 0 1 1 -79.423866,0 39.711933,39.711933 0 1 1 79.423866,0 z" transform="matrix(1.2174692,0,0,1.2174692,-9.1960089,-9.5180383)" id="path4021" style="fill:#fff;fill-opacity:0.4;stroke:none" />
						</g>
						<g class="network" transform="matrix(0.73511491,0,0,0.73511491,14.552273,13.244388)">
							<path d="M 86,43.75 C 82.475,43.75 79.565,46 79.079,50 H 60 c 0,-3 -0.62,-4.209 -1.681,-5.796 l 15.82,-15.945 c 0.576,0.231 1.201,0.304 1.86,0.304 2.762,0 5,-2.27 5,-5.031 0,-2.761 -2.238,-5.016 -5,-5.016 -2.762,0 -5,2.23 -5,4.992 0,1.289 0.501,2.448 1.302,3.335 L 56.883,42.26 C 55.317,40.771 53.274,39.777 51,39.551 V 20.42 c 3.391,-0.486 6,-3.394 6,-6.92 0,-3.866 -3.134,-7 -7,-7 -3.866,0 -7,3.134 -7,7 0,3.526 2.609,6.434 6,6.92 v 19.13 c -2.135,0.212 -4.066,1.102 -5.592,2.443 L 28.489,27.075 C 29.419,26.167 30,24.903 30,23.5 c 0,-2.762 -2.238,-5 -5,-5 -2.762,0 -5,2.238 -5,5 0,2.762 2.238,5 5,5 0.619,0 1.206,-0.127 1.753,-0.333 L 42.045,43.709 C 40.767,45.388 40,47 40,50 H 19.92 C 19.434,46 16.525,43.75 13,43.75 c -3.866,0 -7,3.009 -7,6.875 0,3.867 3.134,7.188 7,7.188 3.526,0 6.434,-2.813 6.92,-5.813 H 40.2 c 0.38,1 1.29,3.3 2.557,4.633 L 28.338,70.927 C 27.452,70.126 26.289,69.563 25,69.563 c -2.762,0 -5,2.207 -5,4.969 0,2.762 2.238,4.984 5,4.984 2.762,0 5,-2.246 5,-5.008 0,-0.659 -0.135,-1.289 -0.366,-1.864 l 14.82,-14.822 c 1.326,0.886 2.875,1.462 4.546,1.628 v 20.13 c -3.391,0.486 -6,3.396 -6,6.921 0,3.867 3.134,7 7,7 3.866,0 7,-3.133 7,-7 0,-3.525 -2.609,-6.435 -6,-6.921 V 59.45 c 1.887,-0.188 3.611,-0.906 5.042,-1.994 L 71.333,72.747 C 71.127,73.294 71,73.881 71,74.5 c 0,2.762 2.238,5 5,5 2.762,0 5,-2.238 5,-5 0,-2.762 -2.238,-5 -5,-5 -1.402,0 -2.666,0.581 -3.574,1.511 L 57.507,56.342 C 58.635,55.059 59.446,53 59.799,52 h 19.28 c 0.486,3 3.396,5.75 6.921,5.75 3.866,0 7,-3.133 7,-7 0,-3.866 -3.134,-7 -7,-7 z" fill="#fff" fill-opacity="0" />
						</g>
						<g class="ia-icon" style="stroke-width:0;">
							<path d="m 48.187909,59.794831 c -2.588314,-0.467406 -4.286394,-2.09885 -5.097362,-4.897328 -0.631807,-2.180234 -0.706042,-4.790801 -0.206008,-7.244511 0.484459,-2.377281 1.204751,-4.137308 2.472594,-6.041757 0.874947,-1.314272 2.936653,-3.548267 3.274621,-3.548267 0.33515,0 1.909144,1.328792 3.126174,2.639171 0.603963,0.650288 1.130968,1.182343 1.17112,1.182343 0.04015,0 0.498664,-0.242857 1.018913,-0.539683 1.014717,-0.578942 2.60457,-1.235448 3.242614,-1.338989 0.302355,-0.04907 0.503499,0.01388 0.881565,0.275883 0.906192,0.627991 2.174376,2.474835 2.695349,3.925214 0.51676,1.438649 0.656899,2.290336 0.718261,4.365225 0.0549,1.856464 0.03327,2.209399 -0.193619,3.159863 -0.91641,3.838867 -4.020561,6.623171 -8.652397,7.760868 -1.406821,0.345551 -3.444933,0.483796 -4.451825,0.301968 z" id="path4162" style="fill:#a0a1a0;stroke-width:.2;" />
						     <path d="m 48.32564,59.721535 c -1.262518,-0.192969 -2.560135,-0.843215 -3.402237,-1.704885 -1.581876,-1.618633 -2.354607,-4.245993 -2.23331,-7.593472 0.121689,-3.358273 0.994568,-6.120307 2.783334,-8.807243 0.873289,-1.311783 2.822408,-3.433545 3.154165,-3.433545 0.33841,0 1.37495,0.868537 2.868805,2.40383 0.758683,0.779727 1.437591,1.417684 1.508687,1.417684 0.0711,0 0.525156,-0.241883 1.009024,-0.537518 0.824478,-0.503743 2.98363,-1.373239 3.410056,-1.373239 0.1055,0 0.42474,0.190862 0.709423,0.424138 1.218717,0.998648 2.308634,2.901102 2.869985,5.009578 0.287376,1.079398 0.318823,1.40665 0.327063,3.403536 0.01,2.418134 -0.09201,3.014982 -0.771149,4.512789 -1.345446,2.967316 -4.535398,5.227909 -8.531754,6.046118 -0.895366,0.183317 -3.112274,0.322381 -3.702092,0.232229 z" id="path4160" style="fill:#93b75b;stroke-width:.2;" />
						     <path d="m 48.72958,59.599946 c -2.515476,-0.36959 -3.920241,-1.362775 -4.90759,-3.469722 -1.33182,-2.842029 -1.343784,-7.214642 -0.02983,-10.90319 0.45794,-1.285539 1.401941,-3.04675 2.214985,-4.132465 0.745855,-0.995994 2.447399,-2.792756 2.644755,-2.792756 0.248114,0 1.693709,1.267995 2.902146,2.545597 l 1.261287,1.333478 0.382447,-0.228568 c 1.059124,-0.632983 2.669119,-1.398106 3.425147,-1.627742 l 0.847775,-0.257504 0.493333,0.341449 c 1.102729,0.763226 2.439828,2.93761 2.94854,4.794899 0.535253,1.954184 0.617912,4.914238 0.187399,6.710724 -0.406475,1.696182 -1.566854,3.513058 -3.030561,4.745134 -2.526129,2.126373 -6.457467,3.364164 -9.339828,2.940666 z" id="path4158" style="fill:#709f28;stroke-width:.2;" />
						     <path d="m 49.434586,59.700745 c -0.985977,-0.113691 -2.077753,-2.800698 -2.37734,-5.850952 -0.258769,-2.634667 0.03398,-6.933965 0.737485,-10.830799 0.301596,-1.670581 0.597007,-2.958798 0.706303,-3.080012 0.04684,-0.05195 0.118838,1.721472 0.159988,3.940936 0.111872,6.033722 0.491913,9.963151 1.225341,12.669397 0.289008,1.066401 0.928374,2.588803 1.142906,2.721391 0.05653,0.03495 0.102796,0.136197 0.102796,0.22501 0,0.164385 -1.001207,0.285315 -1.697479,0.205029 z m 3.011124,-0.748918 c 3.232302,-1.999848 4.436897,-5.003447 3.749964,-9.350354 -0.355458,-2.249332 -1.16575,-4.282693 -2.537749,-6.368264 l -0.723263,-1.09943 0.704879,-0.428192 c 0.938345,-0.570014 2.288549,-1.185562 3.143125,-1.432927 l 0.694574,-0.201052 0.490061,0.339181 c 1.099497,0.760983 2.437224,2.937772 2.945269,4.792633 0.535252,1.954184 0.617911,4.914238 0.187399,6.710724 -0.893182,3.727156 -4.513231,6.695985 -9.251371,7.587113 -0.348482,0.06555 -0.249204,-0.02581 0.597112,-0.549432 z" id="path4156" style="fill:#5e5e5e;stroke-width:.2;" />
						     <path d="m 48.970058,59.457258 c -0.471634,-0.373746 -1.135238,-1.746186 -1.473137,-3.046689 -0.792585,-3.050492 -0.683492,-7.956005 0.29781,-13.391575 0.301596,-1.670581 0.597007,-2.958798 0.706303,-3.080012 0.04684,-0.05195 0.118838,1.721472 0.159988,3.940936 0.111984,6.039816 0.491818,9.962862 1.227399,12.676951 0.285654,1.05399 0.824441,2.342348 1.137115,2.719098 0.07731,0.09315 0.118349,0.191584 0.0912,0.218734 -0.02715,0.02715 -0.451294,0.08528 -0.94254,0.129171 -0.792904,0.07085 -0.928085,0.05214 -1.204136,-0.166614 z m 2.997963,-0.176264 c 0,-0.03645 0.312323,-0.232735 0.694052,-0.436194 2.574762,-1.372335 3.995208,-4.221794 3.781427,-7.585666 -0.189344,-2.979389 -1.086386,-5.648765 -2.697496,-8.027087 -0.321068,-0.473961 -0.58376,-0.895267 -0.58376,-0.936236 0,-0.406627 2.859076,-1.845288 4.043593,-2.034701 0.440675,-0.07047 0.49563,-0.04107 1.169166,0.625438 1.27153,1.258256 2.1414,2.913984 2.626106,4.998582 0.280167,1.204928 0.316678,4.874394 0.05882,5.911405 -0.240283,0.966326 -0.99587,2.52231 -1.6165,3.328864 -1.215026,1.579019 -3.17148,2.910375 -5.512257,3.751065 -0.834997,0.299888 -1.96315,0.532357 -1.96315,0.40453 z" id="path4154" style="fill:#105d34;stroke-width:.2;" />
						     <path d="m 54.953579,57.190061 c 0,-0.05606 0.108802,-0.20039 0.241782,-0.320736 0.33291,-0.301279 0.93948,-1.57665 1.163085,-2.445499 0.393843,-1.530326 0.343585,-4.353215 -0.107363,-6.030361 -0.07057,-0.262474 -0.148994,-0.584914 -0.174269,-0.716535 -0.169615,-0.883284 -1.461351,-3.683749 -1.965313,-4.260775 -0.201909,-0.231183 -0.736699,-1.193297 -0.683555,-1.229753 0.09195,-0.06308 1.436464,-0.303789 2.070901,-0.370755 l 0.7244,-0.07646 0.379279,0.9598 c 1.126404,2.850477 1.593523,4.963387 1.602045,7.246504 0.0096,2.558129 -0.590862,4.380666 -2.026118,6.15025 -0.681656,0.840442 -1.224874,1.325761 -1.224874,1.094322 z" id="path4152" style="fill:#2c2c2c;stroke-width:.2;" />
						 </g>
					</g>
				</svg>
			</div>
			<div class="eight columns">
				<div class="block-text">
					<h2><?php _e('Journalists and<br/>citizen network', 'infoamazonia'); ?></h2>
					<p><?php _e('Get news from a network of journalist which expands through 9 countries and read first hand reports of citizens and NGOs sent directly from the cities, forests and rivers of the Amazon', 'infoamazonia'); ?></p>
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