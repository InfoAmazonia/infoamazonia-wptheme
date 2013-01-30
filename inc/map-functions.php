<?php

function get_map($post_id = false) {
	global $post;
	$post_id = $post_id ? $post_id : $post->ID;

	if(!$post_id)
		return;

	echo '<div class="map-container" style="width:700px;height:500px;"><div id="map_' . $post_id . '" class="map"></div></div>';
	echo '<script type="text/javascript">mappress(' . get_post_meta($post_id, 'map_conf', true) . ');</script>';
}

?>