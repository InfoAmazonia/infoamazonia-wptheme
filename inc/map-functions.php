<?php

function mappress_setup() {
	// register map and map group post types
	include(TEMPLATEPATH . '/inc/map-post-types.php');

	add_theme_support('post-thumbnails');
	add_image_size('map-group-thumb', 230, 152, true);
}
add_action('after_setup_theme', 'mappress_setup');

/*
 * Register/enqueue scripts & styles
 */
function mappress_scripts() {
	wp_register_script('underscore', get_template_directory_uri() . '/lib/underscore-min.js', array(), '1.4.3');
	wp_register_script('mapbox-js', get_template_directory_uri() . '/lib/mapbox.js', array(), '0.6.7');
	wp_enqueue_style('mapbox', get_template_directory_uri() . '/lib/mapbox.css', array(), '0.6.7');

	wp_register_script('d3js', get_template_directory_uri() . '/lib/d3.v2.min.js', array('jquery'), '3.0.5');

	wp_enqueue_script('mappress', get_template_directory_uri() . '/js/mappress.js', array('mapbox-js', 'underscore', 'jquery'), '0.0.6.25');
	wp_enqueue_script('mappress.hash', get_template_directory_uri() . '/js/mappress.hash.js', array('mappress', 'underscore'), '0.0.1.5');
	wp_enqueue_script('mappress.geocode', get_template_directory_uri() . '/js/mappress.geocode.js', array('mappress', 'd3js', 'underscore'), '0.0.2.3');
	wp_enqueue_script('mappress.filterLayers', get_template_directory_uri() . '/js/mappress.filterLayers.js', array('mappress', 'underscore'), '0.0.5');
	wp_enqueue_script('mappress.groups', get_template_directory_uri() . '/js/mappress.groups.js', array('mappress', 'underscore'), '0.0.3.5');
	wp_enqueue_script('mappress.markers', get_template_directory_uri() . '/js/mappress.markers.js', array('mappress', 'underscore'), '0.0.2.11');

	wp_enqueue_style('mappress', get_template_directory_uri() . '/css/mappress.css', array(), '0.0.1.1');

	wp_localize_script('mappress.geocode', 'mappress_labels', array(
		'search_placeholder' => __('Find a location', 'infoamazonia'),
		'results_title' => __('Results', 'infoamazonia'),
		'clear_search' => __('Clear search', 'infoamazonia')
		)
	);

	wp_localize_script('mappress.groups', 'mappress_groups', array('ajaxurl' => admin_url('admin-ajax.php')));

	wp_localize_script('mappress.markers', 'mappress_markers', array('ajaxurl' => admin_url('admin-ajax.php')));
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

	setup_postdata(get_post($post_id));

	get_template_part('content', 'map');

	wp_reset_postdata();
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

	setup_postdata(get_post($post_id));

	get_template_part('content', 'map-group');

	wp_reset_postdata();
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

/*
 * Markers
 */

add_action('wp_ajax_nopriv_markers_geojson', 'mappress_get_markers_data');
add_action('wp_ajax_markers_geojson', 'mappress_get_markers_data');
function mappress_get_markers_data() {

	$map_id = $_REQUEST['map_id'];
	$data = array();

	if(get_post_type($map_id) != 'map' && get_post_type($map_id) != 'map-group')
		return;

	$query = false;
	if(isset($map_id))
		$query = get_post_meta($map_id, 'markers', true);

	if(!$query) { // if no query, show all posts on currently available query

		$query = array(
			'post_type' => 'post',
			'posts_per_page' => -1
		);

		$posts = wp_cache_get('all_posts');
		if($posts === false) {
			$posts = get_posts($query);
			wp_cache_set('all_posts', $posts);
		}

	} else {

		$posts = get_posts($query);

	}

	if($posts) {
		global $post;
		$data['type'] = 'FeatureCollection';
		$data['features'] = array();
		$i = 0;
		foreach($posts as $post) {

			setup_postdata($post);

			$data['features'][$i]['type'] = 'Feature';

			$data['features'][$i]['geometry'] = array();
			$data['features'][$i]['geometry']['type'] = 'Point';
			$data['features'][$i]['geometry']['coordinates'] = array(get_post_meta($post->ID, 'geocode_longitude', true), get_post_meta($post->ID, 'geocode_latitude', true));

			$data['features'][$i]['properties'] = array();
			$data['features'][$i]['properties']['id'] = 'post-' . $post->ID;
			$data['features'][$i]['properties']['title'] = get_the_title($post->ID);
			$data['features'][$i]['properties']['date'] = get_the_date($post->ID);
			$data['features'][$i]['properties']['story'] = get_the_content();
			$data['features'][$i]['properties']['url'] = get_post_meta($post->ID, 'url', true);
			$data['features'][$i]['properties']['source'] = get_post_meta($post->ID, 'publisher', true);

			$i++;

			wp_reset_postdata();
		}
	}

	$data = json_encode($data);
	header('Content Type: application/json');
	echo $data;
	exit;
}

?>