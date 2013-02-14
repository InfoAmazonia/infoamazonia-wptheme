<?php

// map functions
include(TEMPLATEPATH . '/inc/map-functions.php');

// metaboxes
include(TEMPLATEPATH . '/inc/metaboxes/metaboxes.php');

// register taxonomies
include(TEMPLATEPATH . '/inc/taxonomies.php');

// shortcodes
include(TEMPLATEPATH . '/inc/shortcodes/shortcodes.php');

function infoamazonia_scripts() {
	/*
	 * Register scripts & styles
	 */
	// scripts
	wp_register_script('html5', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.6.2');
	// styles
	wp_register_style('site', get_template_directory_uri() . '/css/site.css', array(), '0.0.1');
	wp_register_style('reset', get_template_directory_uri() . '/css/reset.css', array(), '2.0');
	wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), '0.0.2');

	/*
	 * Enqueue scripts & styles
	 */
	// scripts
	wp_enqueue_script('html5');
	// styles
	wp_enqueue_style('site');
	wp_enqueue_style('reset');
	wp_enqueue_style('main');
}
add_action('wp_enqueue_scripts', 'infoamazonia_scripts');


include(TEMPLATEPATH . '/inc/import-geojson.php');