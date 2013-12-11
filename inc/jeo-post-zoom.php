<?php

/* 
 * JEO Post Zoom
 */

class JEO_Post_Zoom {

	function __construct() {

		add_action('jeo_geocode_box', array($this, 'zoom_input'));
		add_action('jeo_geocode_box_save', array($this, 'save_post'));

	}

	function zoom_input($post) {
		$geocode_zoom = get_post_meta($post->ID, 'geocode_zoom', true);
		?>
		<p>
		<?php _e('Zoom', 'ekuatorial'); ?>:
		<input type="text" id="geocode_zoom" name="geocode_zoom" value="<?php if($geocode_zoom) echo $geocode_zoom; ?>" />
		</p>
		<?php
	}

	function save_post($post_id) {

		if(isset($_REQUEST['geocode_zoom'])) {
			update_post_meta($post_id, 'geocode_zoom', $_REQUEST['geocode_zoom']);
		} else {
			delete_post_meta($post_id, 'geocode_zoom');
		}

	}

}

$GLOBALS['jeo_post_zoom'] = new JEO_Post_Zoom();