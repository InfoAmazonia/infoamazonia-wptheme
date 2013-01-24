<?php

// register general metabox files
add_action('admin_footer', 'metaboxes_init');

function metaboxes_init() {
	wp_enqueue_script('mapbox-js', get_template_directory_uri() . '/lib/mapbox.js', array(), '0.6.7');
	wp_enqueue_script('mapbox', get_template_directory_uri() . '/js/mapbox.js', array('mapbox-js'), '0.0.2');
	wp_enqueue_style('mapbox', get_template_directory_uri() . '/lib/mapbox.css', array(), '0.6.7');
}

/* gather metaboxes */

include(TEMPLATEPATH .  '/inc/metaboxes/geocode/geocode.php');
include(TEMPLATEPATH .  '/inc/metaboxes/mapbox/mapbox.php');