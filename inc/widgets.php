<?php

/*
 * Widgets
 */

class InfoAmazonia_Widgets {

	function __construct() {
		add_filter('query_vars', array(&$this, 'query_var'));
		add_action('generate_rewrite_rules', array(&$this, 'generate_rewrite_rule'));
		add_action('template_redirect', array(&$this, 'template_redirect'));
	}

	function query_var($vars) {
		$vars[] = 'widgets';
		return $vars;
	}

	function generate_rewrite_rule($wp_rewrite) {
		$widgets_rule = array(
			'widgets$' => 'index.php?widgets=1'
		);
		$wp_rewrite->rules = $widgets_rule + $wp_rewrite->rules;
	}

	function template_redirect() {
		if(get_query_var('widgets')) {
			add_filter('show_admin_bar', '__return_false');
			$this->template();
			exit;
		}
	}

	function template() {
		get_template_part('content', 'widgets');
		exit;
	}
}

$infoamazonia_widgets = new InfoAmazonia_Widgets;