<?php


/*
 * Register/enqueue scripts & styles
 */
function mappress_scripts() {
	wp_register_script('underscore', get_template_directory_uri() . '/lib/underscore-min.js', array(), '1.4.3');
	wp_register_script('mapbox-js', get_template_directory_uri() . '/lib/mapbox.js', array(), '0.6.7');
	wp_enqueue_style('mapbox', get_template_directory_uri() . '/lib/mapbox.css', array(), '0.6.7');

	wp_register_script('d3js', get_template_directory_uri() . '/lib/d3.v2.min.js', array('jquery'), '3.0.5');

	wp_enqueue_script('mappress', get_template_directory_uri() . '/js/mappress.js', array('mapbox-js', 'jquery'), '0.0.3.6');
	wp_enqueue_script('mappress.geocode', get_template_directory_uri() . '/js/mappress.geocode.js', array('mappress', 'd3js', 'underscore'), '0.0.2');
	wp_enqueue_script('mappress.filterLayers', get_template_directory_uri() . '/js/mappress.filterLayers.js', array('mappress', 'underscore'), '0.0.3.5');

	wp_enqueue_style('mappress', get_template_directory_uri() . '/css/mappress.css', array(), '0.0.1.1');

	wp_localize_script('mappress.geocode', 'mappress_labels', array(
		'search_placeholder' => __('Find a location', 'infoamazonia'),
		'results_title' => __('Results', 'infoamazonia'),
		'clear_search' => __('Clear search', 'infoamazonia')
		)
	);
}
add_action('wp_enqueue_scripts', 'mappress_scripts');

function infoamazonia_scripts() {
	/*
	 * Register scripts & styles
	 */
	// scripts
	wp_register_script('html5', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.6.2');
	// styles
	wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), '0.0.0');

	/*
	 * Enqueue scripts & styles
	 */
	// scripts
	wp_enqueue_script('html5');
	// styles
	wp_enqueue_style('main');
}
add_action('wp_enqueue_scripts', 'infoamazonia_scripts');

// map functions
include(TEMPLATEPATH . '/inc/map-functions.php');

// metaboxes
include(TEMPLATEPATH . '/inc/metaboxes/metaboxes.php');

// register post types
include(TEMPLATEPATH . '/inc/post-types.php');

// shortcodes
include(TEMPLATEPATH . '/inc/shortcodes/shortcodes.php');