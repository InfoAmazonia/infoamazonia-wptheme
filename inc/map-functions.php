<?php

/*
 * Register/enqueue scripts & styles
 */
function mappress_scripts() {
	wp_register_script('underscore', get_template_directory_uri() . '/lib/underscore-min.js', array(), '1.4.3');
	wp_register_script('mapbox-js', get_template_directory_uri() . '/lib/mapbox.js', array(), '0.6.7');
	wp_enqueue_style('mapbox', get_template_directory_uri() . '/lib/mapbox.css', array(), '0.6.7');

	wp_register_script('d3js', get_template_directory_uri() . '/lib/d3.v2.min.js', array('jquery'), '3.0.5');

	wp_enqueue_script('mappress', get_template_directory_uri() . '/js/mappress.js', array('mapbox-js', 'jquery'), '0.0.5.3');
	wp_enqueue_script('mappress.geocode', get_template_directory_uri() . '/js/mappress.geocode.js', array('mappress', 'd3js', 'underscore'), '0.0.2');
	wp_enqueue_script('mappress.filterLayers', get_template_directory_uri() . '/js/mappress.filterLayers.js', array('mappress', 'underscore'), '0.0.4.2');
	wp_enqueue_script('mappress.groups', get_template_directory_uri() . '/js/mappress.groups.js', array('mappress', 'underscore'), '0.0.3.2.1');

	wp_enqueue_style('mappress', get_template_directory_uri() . '/css/mappress.css', array(), '0.0.1.1');

	wp_localize_script('mappress.geocode', 'mappress_labels', array(
		'search_placeholder' => __('Find a location', 'infoamazonia'),
		'results_title' => __('Results', 'infoamazonia'),
		'clear_search' => __('Clear search', 'infoamazonia')
		)
	);

	wp_localize_script('mappress.groups', 'mappress_groups', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'mappress_scripts');

/*
 * Maps
 */

// display map

function mappress_map($post_id = false) {
	global $post;
	$post_id = $post_id ? $post_id : $post->ID;

	if(!$post_id)
		return;

	echo '<div class="map-container"><div id="map_' . $post_id . '" class="map"></div></div>';
	echo '<script type="text/javascript">mappress(' . get_post_meta($post_id, 'map_conf', true) . ');</script>';
}

/*
 * Map groups
 */

// display map group

function mappress_mapgroup($post_id = false) {
	global $post;
	$post_id = $post_id ? $post_id : $post->ID;

	if(!$post_id)
		return;

	$data = get_post_meta($post_id, 'mapgroup_data', true);

	$main_maps = $more_maps = array();
	// separate main maps from "more" maps
	foreach($data['maps'] as $map) {
		if(!isset($map['more']))
			$main_maps[] = $map;
		else
			$more_maps[] = $map;
	}
	?>
	<div class="mapgroup-container">
		<div id="mapgroup-<?php echo $post_id; ?>" class="mapgroup">
			<ul class="map-nav">
				<?php
				$i = 0;
				foreach($main_maps as $map) { ?>
					<li><a href="#" data-map="map_<?php echo $map['id']; ?>" <?php if($i == 0) echo 'class="active"'; ?>><?php echo $map['title']; ?></a></li>
				<?php
				$i++;
				} ?>
			</ul>
			<div class="sidebar">
				<div class="sidebar-inner"></div>
			</div>
			<div class="map-container">
				<div id="mapgroup_<?php echo $post_id; ?>_map" class="map">
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var group = mappress.group(<?php echo $post_id; ?>);
	</script>
	<?php
}

// get data

add_action('wp_ajax_nopriv_mapgroup_data', 'mappress_get_mapgroup_data');
add_action('wp_ajax_mapgroup_data', 'mappress_get_mapgroup_data');
function mappress_get_mapgroup_data() {
	$group_id = $_REQUEST['group_id'];
	$data = array();

	if(get_post_type($group_id) != 'map-group')
		return;

	$group_data = get_post_meta($group_id, 'mapgroup_data', true);

	foreach($group_data['maps'] as $map) {

		$map_title = get_the_title($map['id']);
		$map_id = 'map_' . $map['id'];

		$data['maps'][$map_id] = get_post_meta($map['id'], 'map_data', true);
		$data['maps'][$map_id]['title'] = $map_title;
	}

	$data = json_encode($data);
	header('Content Type: application/json');
	echo $data;
	exit;
}

?>