<?php

// Map
function mappress_map_shortcode($atts) {

	extract(shortcode_atts(
		array(
			'id' => false
		), $atts));

	if(!$id)
		return;

	return get_map($id);
}
add_shortcode('map', 'mappress_map_shortcode');

?>