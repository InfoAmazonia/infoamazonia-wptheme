<?php

/*
 * infoamazonia
 * Blog
 */

class infoamazonia_Blog {

	function __construct() {

		add_action('init', array($this, 'register_taxonomies'));
		add_action('init', array($this, 'register_post_type'));

	}

	function register_post_type() {

		$labels = array( 
			'name' => __('Blog', 'infoamazonia'),
			'singular_name' => __('Post', 'infoamazonia'),
			'add_new' => __('Add post', 'infoamazonia'),
			'add_new_item' => __('Add new post', 'infoamazonia'),
			'edit_item' => __('Edit post', 'infoamazonia'),
			'new_item' => __('New post', 'infoamazonia'),
			'view_item' => __('View post', 'infoamazonia'),
			'search_items' => __('Search post', 'infoamazonia'),
			'not_found' => __('No post found', 'infoamazonia'),
			'not_found_in_trash' => __('No post found in the trash', 'infoamazonia'),
			'menu_name' => __('Blog', 'infoamazonia')
		);

		$args = array( 
			'labels' => $labels,
			'hierarchical' => false,
			'description' => __('infoamazonia Blog', 'infoamazonia'),
			'supports' => array('title', 'editor', 'excerpt', 'author', 'revisions', 'thumbnail', 'comments'),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'has_archive' => true,
			'menu_position' => 4,
			'rewrite' => array('slug' => 'blog', 'with_front' => false)
		);

		register_post_type('blog-post', $args);

	}

	function register_taxonomies() {

		$labels = array(
			'name' => _x('Blog categories', 'Blog category general name', 'infoamazonia'),
			'singular_name' => _x('Blog category', 'Blog category singular name', 'infoamazonia'),
			'all_items' => __('All blog categories', 'infoamazonia'),
			'edit_item' => __('Edit blog category', 'infoamazonia'),
			'view_item' => __('View blog category', 'infoamazonia'),
			'update_item' => __('Update blog category', 'infoamazonia'),
			'add_new_item' => __('Add new blog category', 'infoamazonia'),
			'new_item_name' => __('New blog category name', 'infoamazonia'),
			'parent_item' => __('Parent blog category', 'infoamazonia'),
			'parent_item_colon' => __('Parent blog category:', 'infoamazonia'),
			'search_items' => __('Search blog categories', 'infoamazonia'),
			'popular_items' => __('Popular blog categories', 'infoamazonia'),
			'separate_items_with_commas' => __('Separate blog categories with commas', 'infoamazonia'),
			'add_or_remove_items' => __('Add or remove blog categories', 'infoamazonia'),
			'choose_from_most_used' => __('Choose from most used blog categories', 'infoamazonia'),
			'not_found' => __('No blog categories found', 'infoamazonia')
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_admin_column' => true,
			'hierarchical' => true,
			'query_var' => 'blog-category',
			'rewrite' => array('slug' => 'blog/categories', 'with_front' => false)
		);

		register_taxonomy('blog-category', 'blog-post', $args);

		$labels = array(
			'name' => _x('Blog tags', 'Blog tag general name', 'infoamazonia'),
			'singular_name' => _x('Blog tag', 'Blog tag singular name', 'infoamazonia'),
			'all_items' => __('All blog tags', 'infoamazonia'),
			'edit_item' => __('Edit blog tag', 'infoamazonia'),
			'view_item' => __('View blog tag', 'infoamazonia'),
			'update_item' => __('Update blog tag', 'infoamazonia'),
			'add_new_item' => __('Add new blog tag', 'infoamazonia'),
			'new_item_name' => __('New blog tag name', 'infoamazonia'),
			'parent_item' => __('Parent blog tag', 'infoamazonia'),
			'parent_item_colon' => __('Parent blog tag:', 'infoamazonia'),
			'search_items' => __('Search blog tags', 'infoamazonia'),
			'popular_items' => __('Popular blog tags', 'infoamazonia'),
			'separate_items_with_commas' => __('Separate blog tags with commas', 'infoamazonia'),
			'add_or_remove_items' => __('Add or remove blog tags', 'infoamazonia'),
			'choose_from_most_used' => __('Choose from most used blog tags', 'infoamazonia'),
			'not_found' => __('No blog tags found', 'infoamazonia')
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_admin_column' => true,
			'hierarchical' => false,
			'query_var' => 'blog-tag',
			'rewrite' => array('slug' => 'datasets/tags', 'with_front' => false)
		);

		register_taxonomy('blog-tag', 'blog-post', $args);

	}

}

$GLOBALS['infoamazonia_blog'] = new infoamazonia_Blog();
