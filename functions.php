<?php

// register styles and scripts
add_action('wp_enqueue_scripts', 'infoamazonia_scripts');
function infoamazonia_scripts() {

	// scripts
	wp_enqueue_script('html5', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.6.2');

	// styles
	wp_enqueue_style('main', get_template_directory_uri() . '/css/main.css', array(), '0.0.0');
}

// metaboxes
include(TEMPLATEPATH . '/inc/metaboxes/metaboxes.php');

// register post types
include(TEMPLATEPATH . '/inc/post-types.php');
