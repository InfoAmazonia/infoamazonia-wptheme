<?php

function infoamazonia_scripts() {
	/*
	 * Register scripts & styles
	 */
	// scripts
	wp_register_script('html5', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.6.2');
	// styles
	wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), '0.0.1');
	wp_register_style('site', get_template_directory_uri() . '/css/site.css', array(), '0.0.1');

	/*
	 * Enqueue scripts & styles
	 */
	// scripts
	wp_enqueue_script('html5');
	// styles
	wp_enqueue_style('main');
	wp_enqueue_style('site');
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