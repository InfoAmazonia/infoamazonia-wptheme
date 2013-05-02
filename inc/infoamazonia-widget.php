<?php

/*
 * MapPress embed tool
 */

class InfoAmazonia_Widget {

	function __construct() {
		add_filter('query_vars', array(&$this, 'query_var'));
		add_action('generate_rewrite_rules', array(&$this, 'generate_rewrite_rule'));
		add_action('template_redirect', array(&$this, 'template_redirect'));
	}

	function query_var($vars) {
		$vars[] = 'share';
		return $vars;
	}

	function generate_rewrite_rule($wp_rewrite) {
		$widgets_rule = array(
			'share$' => 'index.php?share=1'
		);
		$wp_rewrite->rules = $widgets_rule + $wp_rewrite->rules;
	}

	function template_redirect() {
		if(get_query_var('share')) {
			$this->template();
			exit;
		}
	}

	function template() {

		$default_map = array_shift(get_posts(array('name' => 'deforestation', 'post_type' => 'map')));

		wp_enqueue_script('infoamazonia-widget', get_stylesheet_directory_uri() . '/js/infoamazonia.widget.js', array('jquery', 'underscore', 'chosen'), '1.3.18');
		wp_localize_script('infoamazonia-widget', 'infoamazonia_widget', array(
			'baseurl' => home_url('/' . qtrans_getLanguage() . '/embed/'),
			'defaultmap' => $default_map->ID
		));
		wp_enqueue_style('infoamazonia-widget', get_stylesheet_directory_uri() . '/css/infoamazonia.widget.css', array(), '1.0');
		get_template_part('content', 'share');
		exit;
	}
}

new InfoAmazonia_Widget;