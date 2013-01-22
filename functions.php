<?php


/*
 * Register/enqueue scripts & styles
 */
function infoamazonia_scripts() {

	/*
	 * Register scripts & styles
	 */
	// scripts
	wp_register_script('html5', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.6.2');
	wp_register_script('mapbox-js', get_template_directory_uri() . '/lib/mapbox.js', array(), '0.6.7');
	wp_register_script('mapbox', get_template_directory_uri() . '/js/mapbox.js', array('mapbox-js'), '0.0.1');
	// styles
	wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), '0.0.0');
	wp_register_style('mapbox', get_template_directory_uri() . '/lib/mapbox.css', array(), '0.6.7');

	/*
	 * Enqueue scripts & styles
	 */
	// scripts
	wp_enqueue_script('html5');
	wp_enqueue_script('mapbox-js');
	wp_enqueue_script('mapbox');
	// styles
	wp_enqueue_style('main');
	wp_enqueue_style('mapbox');

}
add_action('wp_enqueue_scripts', 'infoamazonia_scripts');

// metaboxes
include(TEMPLATEPATH . '/inc/metaboxes/metaboxes.php');

// register post types
include(TEMPLATEPATH . '/inc/post-types.php');
