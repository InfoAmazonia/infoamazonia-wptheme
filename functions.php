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
	wp_register_style('site', get_template_directory_uri() . '/css/site.css', array(), '0.0.2');
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

// infoamazonia setup

function infoamazonia_setup() {

	// text domain
	load_theme_textdomain('infoamazonia', get_template_directory() . '/languages');

	//sidebars
	register_sidebar(array(
		'name' => __('Main widgets', 'infoamazonia'),
		'id' => 'main-sidebar',
		'description' => __('Widgets used on front and inside pages.', 'infoamazonia'),
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

}
add_action('after_setup_theme', 'infoamazonia_setup');

/*
 * qTranslate fixes
 */

// fix forced formated date on qtranslate
function get_the_orig_date($format = false) {
	global $post;
	$date = get_the_date($format);
	if(function_exists('qtrans_getLanguage')) {
		remove_filter('get_the_date', 'qtrans_dateFromPostForCurrentLanguage', 0, 4);
		$date = get_the_date($format);
		add_filter('get_the_date', 'qtrans_dateFromPostForCurrentLanguage', 0, 4);
	}
	return $date;
}

include(TEMPLATEPATH . '/inc/import-geojson.php');