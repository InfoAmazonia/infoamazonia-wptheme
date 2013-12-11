<?php

/* 
	REGISTER TAXONOMIES
*/
function register_taxonomy_publisher() {

    $labels = array( 
        'name' => __('Publishers', 'ekuatorial'),
        'singular_name' => __('Publisher', 'ekuatorial'),
        'search_items' => __('Search publishers', 'ekuatorial'),
        'popular_items' => __('Popular publishers', 'ekuatorial'),
        'all_items' => __('All publishers', 'ekuatorial'),
        'parent_item' => __('Parent publisher', 'ekuatorial'),
        'parent_item_colon' => __('Parent publisher:', 'ekuatorial'),
        'edit_item' => __('Edit publisher', 'ekuatorial'),
        'update_item' => __('Update publisher', 'ekuatorial'),
        'add_new_item' => __('Add new publisher', 'ekuatorial'),
        'new_item_name' => __('New publisher name', 'ekuatorial'),
        'separate_items_with_commas' => __('Separate publishers with commas', 'ekuatorial'),
        'add_or_remove_items' => __('Add or remove publishers', 'ekuatorial'),
        'choose_from_most_used' => __('Choose from most used publishers', 'ekuatorial'),
        'menu_name' => __('Publishers', 'ekuatorial')
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'publisher', 'with_front' => false),
        'query_var' => 'publisher'
    );

    register_taxonomy('publisher', array('post'), $args);
}
add_action( 'jeo_init', 'register_taxonomy_publisher' );