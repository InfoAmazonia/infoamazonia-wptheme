<?php

/*
 * MapPress embed tool
 */

class InfoAmazonia_Widget {

	var $query_var = 'share';
	var $slug = 'share';

	function __construct() {
		add_filter('query_vars', array($this, 'query_var'));
		add_action('generate_rewrite_rules', array($this, 'generate_rewrite_rule'));
		add_action('template_redirect', array($this, 'template_redirect'));
		add_action('init', array($this, 'embed_map_query'), 1);
		add_filter('wp_nav_menu_items', array($this, 'nav'), 10, 2);
		add_action('mappress_before_embed', array($this, 'print_scripts'));
	}

	function query_var($vars) {
		$vars[] = $this->query_var;
		return $vars;
	}

	function generate_rewrite_rule($wp_rewrite) {
		$widgets_rule = array(
			$this->slug . '$' => 'index.php?share=1'
		);
		$wp_rewrite->rules = $widgets_rule + $wp_rewrite->rules;
	}

	function template_redirect() {
		if(get_query_var($this->query_var)) {
			$this->template();
			exit;
		}
	}

	function template() {

		$default_map = array_shift(get_posts(array('name' => 'deforestation', 'post_type' => 'map')));

		wp_enqueue_script('infoamazonia-widget', get_stylesheet_directory_uri() . '/js/infoamazonia.widget.js', array('jquery', 'underscore', 'chosen'), '1.5.3');
		wp_localize_script('infoamazonia-widget', 'infoamazonia_widget', array(
			'baseurl' => home_url('/' . qtrans_getLanguage() . '/embed/'),
			'defaultmap' => $default_map->ID,
			'default_label' => __('default', 'infoamazonia')
		));
		wp_enqueue_style('infoamazonia-widget', get_stylesheet_directory_uri() . '/css/infoamazonia.widget.css', array(), '1.0');
		get_template_part('content', 'share');
		exit;
	}

	function embed_map_query() {
		if(isset($_GET['map_id'])) {
			mappress_set_map(get_post($_GET['map_id']));
		}
	}

	function nav($items, $args) {
		$share = '<li class="share' . ((get_query_var($this->query_var)) ? ' current_page_item' : '') . '"><a href="' . $this->get_share_url() . '">' . __('Share a map', 'infoamazonia') . '</a></li>';
		return $items . $share;
	}

	// functions

	function get_share_url($vars = array()) {
		$query = http_build_query($vars);
		return home_url('/' . qtrans_getLanguage() . '/' . $this->slug . '/?' . $query);
	}

	/*
	 * Print
	 */
	function print_scripts() {

		wp_enqueue_script('infoamazonia-print', get_stylesheet_directory_uri() . '/js/infoamazonia.print.js', array('jquery', 'imagesloaded'));

	}
}

$infoamazonia_widget = new InfoAmazonia_Widget();

function infoamazonia_get_share_url($vars = array()) {
	global $infoamazonia_widget;
	return $infoamazonia_widget->get_share_url($vars);
}