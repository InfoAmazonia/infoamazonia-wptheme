<?php

/*
* Countries specials
*/

class InfoAmazonia_Countries_Special {

  function __construct() {

    add_action('jeo_init', array($this, 'register_taxonomy'));

  }

  function register_taxonomy() {

    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
      'name'              => _x( 'Countries', 'taxonomy general name', 'infoamazonia' ),
      'singular_name'     => _x( 'Country', 'taxonomy singular name', 'infoamazonia' ),
      'search_items'      => __( 'Search Countries', 'infoamazonia' ),
      'all_items'         => __( 'All Countries', 'infoamazonia' ),
      'parent_item'       => __( 'Parent Country', 'infoamazonia' ),
      'parent_item_colon' => __( 'Parent Country:', 'infoamazonia' ),
      'edit_item'         => __( 'Edit Country', 'infoamazonia' ),
      'update_item'       => __( 'Update Country', 'infoamazonia' ),
      'add_new_item'      => __( 'Add New Country', 'infoamazonia' ),
      'new_item_name'     => __( 'New Country Name', 'infoamazonia' ),
      'menu_name'         => __( 'Countries', 'infoamazonia' ),
    );

    $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'country' ),
    );

    register_taxonomy( 'country', array( 'post' ), $args );

  }

}

$infoamazonia_countries_special = new InfoAmazonia_Countries_Special();
