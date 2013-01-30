<?php

function get_map($post_id) {
	global $post;
	$post_id = $post_id ? $post_id : $post->ID;

	if(!$post_id)
		return;

	echo '<div class="map-container"><div id="map_' . $post_id . '" class="map" style="width:500px;height:500px;"></div></div>';
	echo '<script type="text/javascript">jQuery(document).ready(function() { mappress.build(' . get_post_meta($post_id, 'map_conf', true) . ') });</script>';
}

?>