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
</head>
<body <?php body_class(get_bloginfo('language')); ?>>

<section id="embed-map">
	<?php
		$conf = array();
		$conf['containerID'] = 'map_embed';
		$conf['disableHash'] = true;
		if(isset($_GET['map_id'])) {
			$conf['postID'] = $_GET['map_id'];
		}
		if(isset($_GET['no_stories']) && $_GET['no_stories'] == 1) {
			$conf['disableMarkers'] = true;
		}
		if(isset($_GET['layers'])) {
			if(isset($conf['postID']))
				unset($conf['postID']);
			$conf['layers'] = explode(',', $_GET['layers']);
		}
		$conf = json_encode($conf);
	?>
	<div class="map-container"><div id="map_embed" class="map"></div></div>
	<script type="text/javascript">mappress(<?php echo $conf; ?>);</script>
</section>

<header id="embed-header">
	<h1><a href="<?php echo home_url('/'); ?>" target="_blank"><?php bloginfo('name'); ?><span>&nbsp;</span></a></h1>
</header>

<?php wp_footer(); ?>
</body>
</html>