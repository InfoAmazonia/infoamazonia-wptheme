<?php

/*
 * Slider
 */

class InfoAmazonia_Slider {


	function __construct() {
		add_action('init', array($this, 'init'));
	}

	function init() {

		$this->register_post_type();
		$this->acf_fields();
		add_filter('post_link', array($this, 'post_link'));
		add_filter('the_permalink', array($this, 'post_link'));

	}

	function register_post_type() {

		$labels = array(
			'name' => __('Slider', 'infoamazonia'),
			'singular_name' => __('Slider item', 'infoamazonia'),
			'add_new' => __('Add slider item', 'infoamazonia'),
			'add_new_item' => __('Add new slider item', 'infoamazonia'),
			'edit_item' => __('Edit slider item', 'infoamazonia'),
			'new_item' => __('New slider item', 'infoamazonia'),
			'view_item' => __('View slider item', 'infoamazonia'),
			'search_items' => __('Search slider items', 'infoamazonia'),
			'not_found' => __('No slider item found', 'infoamazonia'),
			'not_found_in_trash' => __('No slider item found in the trash', 'infoamazonia'),
			'menu_name' => __('Featured slider', 'infoamazonia')
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			'description' => __('Arte Fora do Museu slider', 'infoamazonia'),
			'supports' => array('title', 'thumbnail', 'editor'),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'has_archive' => false,
			'menu_position' => 5
		);

		register_post_type('slider', $args);

	}

	function acf_fields() {

		/*
		 * ACF Fields
		 */
		if(function_exists("register_field_group")) {

			$translate_fields = array(
				'wysiwyg' => 'wysiwyg',
				'text' => 'text',
				'textarea' => 'textarea'
			);

			if(function_exists('qtranxf_getLanguage') && 1 == 0) {
				foreach($translate_fields as &$field) {
					$field = 'qtranslate_' . $field;
				}
			}

			register_field_group(array (
				'id' => 'acf_slider-settings',
				'title' => 'Slider settings',
				'fields' => array (
					array (
						'default_value' => '',
						'formatting' => 'html',
						'key' => 'field_51e32e3c411bd',
						'label' => 'Link',
						'name' => 'slider_url',
						'type' => $translate_fields['text'],
						'instructions' => 'Link to where the slider item will redirect',
						'required' => 1,
					)
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'slider',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'no_box',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));

		}

	}

	function post_link($permalink) {
		global $post;
		if(get_post_type() == 'slider')
			return get_field('slider_url');
		return $permalink;
	}

}

$ia_slider = new InfoAmazonia_Slider();
