<?php

/*
 * infoamazonia
 * Projects
 */

class infoamazonia_Projects {

	function __construct() {

		add_action('init', array($this, 'register_post_type'));
		$this->acf_fields();

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
				'id' => 'acf_project-settings',
				'title' => 'Project settings',
				'fields' => array (
					array (
						'default_value' => '',
						'formatting' => 'html',
						'key' => 'field_project_url',
						'label' => 'Project url',
						'name' => 'project_url',
						'type' => $translate_fields['text'],
						'instructions' => 'URL to the project',
						'required' => 1,
					)
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'project',
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

}

$GLOBALS['infoamazonia_projects'] = new infoamazonia_Projects();
