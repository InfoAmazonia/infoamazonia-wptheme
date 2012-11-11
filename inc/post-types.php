<?php

/*
REGISTER POST TYPES
*/

add_action( 'init', 'register_cpt_map' );

function register_cpt_map() {
    $labels = array( 
        'name' => 'Mapas',
        'singular_name' => 'Mapa',
        'add_new' => 'Adicionar novo mapa',
        'add_new_item' => 'Adicionar novo mapa',
        'edit_item' => 'Editar mapa',
        'new_item' => 'Novo mapa',
        'view_item' => 'Ver mapa',
        'search_items' => 'Buscar mapas',
        'not_found' => 'Nenhum mapa foi encontrado',
        'not_found_in_trash' => 'Nenhum mapa foi encontrado na lixeira',
        'menu_name' => 'Mapas'
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Mapas do MapBox.',
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

add_action( 'init', 'register_cpt_maps_menu' );

function register_cpt_maps_menu() {
    $labels = array( 
        'name' => 'Menus de mapas',
        'singular_name' => 'Menu de mapas',
        'add_new' => 'Adicionar novo',
        'add_new_item' => 'Adicionar novo menu de mapas',
        'edit_item' => 'Editar menu de mapas',
        'new_item' => 'Novo menu de mapas',
        'view_item' => 'Ver menu de mapas',
        'search_items' => 'Buscar menu de mapas',
        'not_found' => 'Nenhum menu de mapa foi encontrado',
        'not_found_in_trash' => 'Nenhum menu de mapa foi encontrado na lixeira',
        'menu_name' => 'Menus de Mapas'
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Agrupamento de mapas do MapBox.',
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

    register_post_type( 'maps-menu', $args );
}

function maps_menu_menu() {
    add_submenu_page('edit.php?post_type=map', 'Menus de mapas', 'Menus de mapas', 'edit_posts', 'edit.php?post_type=maps-menu');
    add_submenu_page('edit.php?post_type=map', 'Adicionar novo menu', 'Adicionar novo menu de mapas', 'edit_posts', 'post-new.php?post_type=maps-menu');
}

add_action('admin_menu', 'maps_menu_menu');