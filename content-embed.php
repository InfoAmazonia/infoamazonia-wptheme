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

<header id="embed-header">
	<h1><a href="<?php echo home_url('/'); ?>" target="_blank"><?php bloginfo('name'); ?><span>&nbsp;</span></a></h1>
</header>

<section id="embed-map">
	<?php
	$conf = array();
	$conf['containerID'] = 'map_embed';
	$conf['disableHash'] = true;
	$conf['mainMap'] = true;
	if(isset($_GET['map_id'])) {
		$conf['postID'] = $_GET['map_id'];
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
		$conf['center'] = array();
		$conf['center']['lat'] = $_GET['lat'];
		$conf['center']['lon'] = $_GET['lon'];
		$conf['forceCenter'] = true;
	}
	$conf = json_encode($conf);
	?>
	<script type="text/javascript">
		(function($) {

			mappress(<?php echo $conf; ?>, function(map) {

				var track = function(m) {
					var c = m.center();
					$('#latitude').val(c.lat);
					$('#longitude').val(c.lon);
					$('#zoom').val(m.zoom());
				}

				map.addCallback('zoomed', track);
				map.addCallback('panned', track);

			});

		})(jQuery);
	</script>

	<input type="hidden" id="latitude" />
	<input type="hidden" id="longitude" />
	<input type="hidden" id="zoom" />
	<div class="map-container"><div id="map_embed" class="map"></div></div>
</section>

<script type="text/javascript">
	if(window.location.hash == '#print') {
		jQuery(document).ready(function($) {
			$('#print-css').attr('media', 'all');
			mappress.markerCentered(function() {
				window.print();
			});
		});
	}
</script>

<?php wp_footer(); ?>
</body>
</html>