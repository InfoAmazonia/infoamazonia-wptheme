<?php

// metaboxes
include(STYLESHEETPATH . '/inc/metaboxes/metaboxes.php');

// set OSM geocode
function infoamazonia_geocode_service() {
	return 'osm';
}
add_filter('mappress_geocode_service', 'infoamazonia_geocode_service');

function infoamazonia_scripts() {
	/*
	 * Register scripts & styles
	 */

	/* Shadowbox */
	wp_register_script('shadowbox', get_stylesheet_directory_uri() . '/lib/shadowbox/shadowbox.js', array('jquery'), '3.0.3');
	wp_register_style('shadowbox', get_stylesheet_directory_uri() . '/lib/shadowbox/shadowbox.css', array(), '3.0.3');

	// scripts
	wp_register_script('html5', get_stylesheet_directory_uri() . '/js/html5shiv.js', array(), '3.6.2');
	wp_register_script('submit-story', get_stylesheet_directory_uri() . '/js/submit-story.js', array('jquery'), '0.0.3.14');

	// custom marker system
	wp_deregister_script('mappress.markers');
	wp_register_script('infoamazonia.markers', get_stylesheet_directory_uri() . '/js/infoamazonia.markers.js', array('mappress', 'underscore', 'shadowbox'), '0.0.5.16', true);

	// styles
	wp_register_style('site', get_stylesheet_directory_uri() . '/css/site.css', array(), '1.1'); // old styles
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
	wp_enqueue_style('shadowbox');

	wp_localize_script('submit-story', 'infoamazonia_submit', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'success_label' => __('Success! Thank you, your story will be reviewed by one of our editors and soon will be online.', 'infoamazonia'),
		'error_label' => __('Oops, please try again in a few minutes.', 'infoamazonia')
	));

	global $marker_query;
	wp_localize_script('infoamazonia.markers', 'infoamazonia_markers', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'query' => $marker_query->query,
		'stories_label' => __('stories', 'infoamazonia'),
		'home' => is_front_page(),
		'copy_embed_label' => __('Copy the embed code', 'infoamazonia'),
		'share_label' => __('Share this', 'infoamazonia'),
		'site_url' => home_url('/'),
		'read_more_label' => __('Read', 'infoamazonia'),
		'lightbox_label' => array(
			'slideshow' => __('Open slideshow', 'infoamazonia'),
			'videos' => __('Watch video gallery', 'infoamazonia'),
			'video' => __('Watch video', 'infoamazonia'),
			'images' => __('View image gallery', 'infoamazonia'),
			'image' => __('View fullscreen image', 'infoamazonia')
		)
	));

}
add_action('wp_enqueue_scripts', 'infoamazonia_scripts', 11);

// infoamazonia setup

function infoamazonia_setup() {

	// register taxonomies
	include(STYLESHEETPATH . '/inc/taxonomies.php');
	// taxonomy meta
	include(STYLESHEETPATH . '/inc/taxonomies-meta.php');

	add_theme_support('post-thumbnails');
	add_image_size('post-thumb', 245, 90, true);
	add_image_size('map-thumb', 200, 200, true);

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

// slideshow
include(STYLESHEETPATH . '/inc/slideshow.php');

// ajax calendar
include(STYLESHEETPATH . '/inc/ajax-calendar.php');

// custom permalink url
function infoamazonia_permalink($permalink, $post) {
	//global $post;
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

// geojson query filter
function infoamazonia_geojson_api_query($query) {
	$query['posts_per_page'] = 20;
	return $query;
}
add_filter('mappress_geojson_api_query', 'infoamazonia_geojson_api_query');

// custom marker data
function infoamazonia_marker_data($data) {
	global $post;
	$data['content'] = infoamazonia_strip_content_media();
	$data['slideshow'] = infoamazonia_get_content_media();
	// source
	$publishers = get_the_terms($post->ID, 'publisher');
	if($publishers) {
		$publisher = array_shift($publishers);
		$data['source'] = apply_filters('single_cat_title', $publisher->name);
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

// geocode box
include(STYLESHEETPATH . '/inc/geocode-box.php');

// submit story
include(STYLESHEETPATH . '/inc/submit-story.php');

// import geojson
//include(STYLESHEETPATH . '/inc/import-geojson.php');

// remove page from search result

function infoamazonia_remove_page_from_search($query) {
	if($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts', 'infoamazonia_remove_page_from_search');

function infoamazonia_all_markers_if_none($posts, $query) {
	if(empty($posts))
		$posts = get_posts(array('post_type' => 'post', 'posts_per_page' => -1));
	return $posts;
}
add_filter('mappress_the_markers', 'infoamazonia_all_markers_if_none', 10, 2);

// multilanguage publishers
add_action('publisher_add_form', 'qtrans_modifyTermFormFor');
add_action('publisher_edit_form', 'qtrans_modifyTermFormFor');

// limit markers per page
function infoamazonia_markers_limit() {
	return 100;
}
add_filter('mappress_markers_limit', 'infoamazonia_markers_limit');

// flush w3tc on save_post
function infoamazonia_flush_w3tc() {
	if(function_exists('flush_pgcache')) {
		flush_pgcache();
		error_log('test');
	}
}
add_action('save_post', 'infoamazonia_flush_w3tc');