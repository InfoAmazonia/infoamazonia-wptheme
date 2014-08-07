<html id="embedded" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php
	global $page, $paged;

	wp_title( '|', true, 'right' );

	bloginfo( 'name' );

	$site_description = get_bloginfo('description', 'display');
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . __('Page', 'infoamazonia') . max($paged, $page);

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.ico" type="image/x-icon" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php wp_head(); ?>
<link rel="stylesheet" type="text/css" media="print" id="print-css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/print.css" />
</head>
<body <?php body_class(get_bloginfo('language')); ?>>


<?php
$embed_title = get_bloginfo('name');
$conf = array();
$conf['containerID'] = 'map_embed';
$conf['disableHash'] = true;
$conf['mainMap'] = true;
if(isset($_GET['map_id'])) {
	$conf['postID'] = $_GET['map_id'];
	$embed_title = get_the_title($_GET['map_id']);
}
if(isset($_GET['no_stories'])) {
	$conf['disableMarkers'] = true;
}
if(isset($_GET['layers'])) {
	$conf['layers'] = explode(',', $_GET['layers']);
	if(isset($conf['postID']))
		unset($conf['postID']);
}
if(isset($_GET['zoom'])) {
	$conf['zoom'] = $_GET['zoom'];
}
if(isset($_GET['lat']) && isset($_GET['lon'])) {
	$conf['center'] = array($_GET['lat'], $_GET['lon']);
	$conf['forceCenter'] = true;
}
//$json_conf = json_encode($conf);

if($_GET['p']) {
	$embed_title = get_the_title($_GET['p']);
}

$json_conf = jeo_get_map_embed_conf();
?>

<header id="embed-header">
	<h1><a href="<?php echo home_url('/'); ?>" target="_blank"><?php bloginfo('name'); ?><span>&nbsp;</span></a></h1>
	<h2 id="embed-title" style="display:none;"><?php echo $embed_title; ?></h2>
</header>

<section id="embed-map">
	<script type="text/javascript">
		(function($) {
			jeo(<?php echo $json_conf; ?>, function(map) {

				var track = function() {
					var c = map.getCenter();
					$('#latitude').val(c.lat);
					$('#longitude').val(c.lng);
					$('#zoom').val(map.getZoom());
				}

				map.on('zoomend', track);
				map.on('dragend', track);

			});

		})(jQuery);
	</script>

	<input type="hidden" id="latitude" />
	<input type="hidden" id="longitude" />
	<input type="hidden" id="zoom" />
	<div class="map-container"><div id="map_embed" class="map"></div></div>
</section>

<?php
if(isset($_GET['print'])) {

	// print image url
	$print_settings = array(
		'map_id_or_layers' => false,
		'lat' => null,
		'lon' => null,
		'zoom' => null
	);

	if(isset($conf['postID'])) {
		$legend = jeo_get_map_legend($conf['postID']);
		if($legend)
			echo '<div id="print-legend">' . jeo_get_map_legend($conf['postID']) . '</div>';
		
		$print_settings['map_id_or_layers'] = $conf['postID'];
	} else {
		$print_settings['map_id_or_layers'] = $conf['layers'];
	}

	if(isset($conf['center'])) {
		$print_settings['lat'] = $conf['center'][0];
		$print_settings['lon'] = $conf['center'][1];
	} elseif(isset($_GET['p'])) {
		$coordinates = jeo_get_marker_coordinates($_GET['p']);
		$print_settings['lat'] = $coordinates[1];
		$print_settings['lon'] = $coordinates[0];
		$print_settings['zoom'] = 7;
	}

	if(isset($conf['zoom'])) {
		$print_settings['zoom'] = 'zoom';
	}

	$image_url = jeo_get_mapbox_image($print_settings['map_id_or_layers'], 640, 400, $print_settings['lat'], $print_settings['lon'], $print_settings['zoom']);

	?>
	<script type="text/javascript">

		if(window.location.hash == '#print') {
			jQuery(document).ready(function($) {
				$('#print-css').attr('media', 'all');
				infoamazoniaPrint({}, '<?php echo $image_url; ?>');
			});
		}

	</script>
<?php
} ?>

<?php wp_footer(); ?>
</body>
</html>