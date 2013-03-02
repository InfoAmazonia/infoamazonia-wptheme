<?php

// metaboxes
include(STYLESHEETPATH . '/inc/metaboxes/metaboxes.php');

// register taxonomies
include(STYLESHEETPATH . '/inc/taxonomies.php');

function infoamazonia_scripts() {
	/*
	 * Register scripts & styles
	 */
	// scripts
	wp_register_script('html5', get_stylesheet_directory_uri() . '/js/html5shiv.js', array(), '3.6.2');
	wp_register_script('submit-story', get_stylesheet_directory_uri() . '/js/submit-story.js', array('jquery'), '0.0.3.14');

	// custom marker system
	wp_deregister_script('mappress.markers');
	wp_register_script('infoamazonia.markers', get_stylesheet_directory_uri() . '/js/infoamazonia.markers.js', array('mappress', 'underscore'), '0.0.4.13');

	// styles
	wp_register_style('site', get_stylesheet_directory_uri() . '/css/site.css', array(), '1.0'); // old styles
	wp_register_style('reset', get_stylesheet_directory_uri() . '/css/reset.css', array(), '2.0');
	wp_register_style('main', get_stylesheet_directory_uri() . '/css/main.css', array(), '1.0');

	/*
	 * Enqueue scripts & styles
	 */
	// scripts
	wp_enqueue_script('html5');
	wp_enqueue_script('submit-story');
	wp_enqueue_script('infoamazonia.markers');
	// styles
	wp_enqueue_style('site');
	wp_enqueue_style('reset');
	wp_enqueue_style('main');

	wp_localize_script('submit-story', 'infoamazonia_submit', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'success_label' => __('Success! Thank you, your story will be reviewed by one of our editors and soon will be online.', 'infoamazonia'),
		'error_label' => __('Oops, please try again in a few minutes.', 'infoamazonia')
	));

	wp_localize_script('infoamazonia.markers', 'infoamazonia_markers', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'query' => mappress_get_marker_query_args(),
		'stories_label' => __('stories', 'infoamazonia'),
		'home' => is_front_page(),
		'copy_embed_label' => __('Copy the embed code', 'infoamazonia'),
		'share_label' => __('Share this', 'infoamazonia'),
		'site_url' => home_url('/'),
		'read_more_label' => __('Read', 'infoamazonia')
	));
}
add_action('wp_enqueue_scripts', 'infoamazonia_scripts', 11);

// infoamazonia setup

function infoamazonia_setup() {

	add_theme_support('post-thumbnails');
	add_image_size('post-thumb', 245, 90, true);

	// text domain
	load_child_theme_textdomain('infoamazonia', get_stylesheet_directory() . '/languages');

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

// delete all transients
function infoamazonia_clear_transients() {
	global $wpdb;
	$wpdb->query("DELETE FROM `wp_options` WHERE `option_name` LIKE ('_transient_%');");
}
//add_action('init', 'infoamazonia_clear_transients');

// custom permalink url
function infoamazonia_permalink($permalink, $post) {
	return get_post_meta($post->ID, 'url', true);
}
add_filter('post_link', 'infoamazonia_permalink', 10, 2);

// story fragment title
add_filter('wp_title', 'infoamazonia_story_fragment_title', 10, 2);
function infoamazonia_story_fragment_title($title, $sep) {
	if(isset($_GET['_escaped_fragment_'])) {
		$args = substr($_GET['_escaped_fragment_'], 1);
		parse_str($args, $query);
		if(isset($query['story'])) {
			$title = get_the_title(substr($query['story'], 9));
			return $title . ' ' . $sep . ' ';
		}
	}
	return $title;
}

// custom marker data
function infoamazonia_marker_data($data) {
	global $post;
	$data['content'] = apply_filters('the_content', get_the_content());
	// source
	$publishers = get_the_terms($post->ID, 'publisher');
	if($publishers) {
		$publisher = array_shift($publishers);
		$data['source'] = $publisher->name;
	}
	// thumbnail
	$thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumb');
	if($thumb_src)
		$data['thumbnail'] = $thumb_src[0];
	else {
		$data['thumbnail'] = get_post_meta($post->ID, 'picture', true);
	}
	// maps
	/* under construction
	$maps = get_post_meta($post->ID, 'maps');
	if($maps && !empty($maps)) {
		$data['maps'] = array();
		foreach($maps as $map) {
			$data['maps'][] = $map;
		}
	}
	*/
	return $data;
}
add_filter('mappress_marker_data', 'infoamazonia_marker_data');

// submit story
include(STYLESHEETPATH . '/inc/submit-story.php');

//include(STYLESHEETPATH . '/inc/import-geojson.php');

// remove page from search result

function infoamazonia_remove_page_from_search($query) {
	if($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts', 'infoamazonia_remove_page_from_search');