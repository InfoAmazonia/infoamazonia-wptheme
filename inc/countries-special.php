<?php

/*
* Countries specials
*/

class InfoAmazonia_Countries_Special {

  function __construct() {

    add_action('jeo_init', array($this, 'register_taxonomy'));
    add_action('jeo_init', array($this, 'register_field_group'));

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

  function register_field_group() {

    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array (
      	'key' => 'group_57c9b82aec81d',
      	'title' => 'Country settings',
      	'fields' => array (
      		array (
      			'key' => 'field_57c9b6e64167e',
      			'label' => 'Header image',
      			'name' => 'header_image',
      			'type' => 'image',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array (
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'return_format' => 'array',
      			'preview_size' => 'medium',
      			'library' => 'all',
      			'min_width' => '',
      			'min_height' => '',
      			'min_size' => '',
      			'max_width' => '',
      			'max_height' => '',
      			'max_size' => '',
      			'mime_types' => '',
      		),
      	),
      	'location' => array (
      		array (
      			array (
      				'param' => 'taxonomy',
      				'operator' => '==',
      				'value' => 'country',
      			),
      		),
      	),
      	'menu_order' => 0,
      	'position' => 'normal',
      	'style' => 'seamless',
      	'label_placement' => 'top',
      	'instruction_placement' => 'label',
      	'hide_on_screen' => '',
      	'active' => 1,
      	'description' => '',
      ));

    endif;

  }

}

$infoamazonia_countries_special = new InfoAmazonia_Countries_Special();
