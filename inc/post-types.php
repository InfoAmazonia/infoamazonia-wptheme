<?php

/*
REGISTER POST TYPES
*/

add_action( 'init', 'register_cpt_map' );

function register_cpt_map() {
    $labels = array( 
        'name' => __('Maps', 'infoamazonia'),
        'singular_name' => _('Map', 'infoamazonia'),
        'add_new' => __('Add new map', 'infoamazonia'),
        'add_new_item' => __('Add new map', 'infoamazonia'),
        'edit_item' => __('Edit map', 'infoamazonia'),
        'new_item' => __('New map', 'infoamazonia'),
        'view_item' => __('View map'),
        'search_items' => __('Search maps', 'infoamazonia'),
        'not_found' => __('No map found', 'infoamazonia'),
        'not_found_in_trash' => __('No map found in the trash', 'infoamazonia'),
        'menu_name' => __('Maps', 'infoamazonia')
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('MapBox Maps', 'infoamazonia'),
        'supports' => array( 'title', 'excerpt'),

        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 4,

        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => 'maps',
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array('slug' => 'maps', 'with_front' => false),
        'capability_type' => 'post'
    );

    register_post_type( 'map', $args );
}

add_action( 'init', 'register_cpt_maps_group' );

function register_cpt_maps_group() {
    $labels = array( 
        'name' => __('Maps groups', 'infoamazonia'),
        'singular_name' => __('Maps group', 'infoamazonia'),
        'add_new' => __('Add new maps group', 'infoamazonia'),
        'add_new_item' => __('Add new maps group', 'infoamazonia'),
        'edit_item' => __('Edit maps group', 'infoamazonia'),
        'new_item' => __('New maps group', 'infoamazonia'),
        'view_item' => __('View maps group', 'infoamazonia'),
        'search_items' => __('Search maps group', 'infoamazonia'),
        'not_found' => __('No maps group found', 'infoamazonia'),
        'not_found_in_trash' => __('No maps group found in the trash', 'infoamazonia'),
        'menu_name' => __('Maps groups', 'infoamazonia')
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('MapBox maps agroupment', 'infoamazonia'),
        'supports' => array( 'title', 'excerpt'),

        'public' => false,
        'show_ui' => true,
        'show_in_menu' => false,

        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'maps-group', $args );
}

function maps_menu_menu() {
    add_submenu_page('edit.php?post_type=map', __('Maps groups', 'infoamazonia'), __('Maps groups', 'infoamazonia'), 'edit_posts', 'edit.php?post_type=maps-group');
    add_submenu_page('edit.php?post_type=map', __('Add new group', 'infoamazonia'), __('Add new maps group', 'infoamazonia'), 'edit_posts', 'post-new.php?post_type=maps-group');
}

add_action('admin_menu', 'maps_menu_menu');