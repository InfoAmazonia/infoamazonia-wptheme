<?php

/* 
	REGISTER TAXONOMIES
*/
function register_taxonomy_publisher() {

    $labels = array( 
        'name' => __('Publishers', 'infoamazonia'),
        'singular_name' => __('Publisher', 'infoamazonia'),
        'search_items' => __('Search publishers', 'infoamazonia'),
        'popular_items' => __('Popular publishers', 'infoamazonia'),
        'all_items' => __('All publishers', 'infoamazonia'),
        'parent_item' => __('Parent publisher', 'infoamazonia'),
        'parent_item_colon' => __('Parent publisher:', 'infoamazonia'),
        'edit_item' => __('Edit publisher', 'infoamazonia'),
        'update_item' => __('Update publisher', 'infoamazonia'),
        'add_new_item' => __('Add new publisher', 'infoamazonia'),
        'new_item_name' => __('New publisher name', 'infoamazonia'),
        'separate_items_with_commas' => __('Separate publishers with commas', 'infoamazonia'),
        'add_or_remove_items' => __('Add or remove publishers', 'infoamazonia'),
        'choose_from_most_used' => __('Choose from most used publishers', 'infoamazonia'),
        'menu_name' => __('Publishers', 'infoamazonia')
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