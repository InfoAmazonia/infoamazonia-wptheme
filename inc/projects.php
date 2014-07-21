<?php

/*
 * infoamazonia
 * Projects
 */

class infoamazonia_Projects {

	function __construct() {

		add_action('init', array($this, 'register_taxonomies'));
		add_action('init', array($this, 'register_post_type'));
		add_filter('upload_mimes', array($this, 'upload_mimes'));
		add_action('init', array($this, 'register_field_groups'));

	}

	function register_post_type() {

		$labels = array( 
			'name' => __('Projects', 'infoamazonia'),
			'singular_name' => __('Project', 'infoamazonia'),
			'add_new' => __('Add project', 'infoamazonia'),
			'add_new_item' => __('Add new project', 'infoamazonia'),
			'edit_item' => __('Edit project', 'infoamazonia'),
			'new_item' => __('New project', 'infoamazonia'),
			'view_item' => __('View project', 'infoamazonia'),
			'search_items' => __('Search project', 'infoamazonia'),
			'not_found' => __('No project found', 'infoamazonia'),
			'not_found_in_trash' => __('No project found in the trash', 'infoamazonia'),
			'menu_name' => __('Projects', 'infoamazonia')
		);

		$args = array( 
			'labels' => $labels,
			'hierarchical' => false,
			'description' => __('infoamazonia Projects', 'infoamazonia'),
			'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments'),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'has_archive' => true,
			'menu_position' => 4,
			'rewrite' => array('slug' => 'projects', 'with_front' => false)
		);

		register_post_type('project', $args);

	}

}

$GLOBALS['infoamazonia_projects'] = new infoamazonia_Projects();
