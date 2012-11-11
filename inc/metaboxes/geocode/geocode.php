<?php

add_action('admin_footer', 'geocoding_init');
add_action('add_meta_boxes', 'geocoding_add_meta_box');
add_action('save_post', 'geocoding_save_postdata');

function geocoding_init() {
	wp_enqueue_script('google-maps-api', 'http://maps.googleapis.com/maps/api/js?key=AIzaSyAKPKeHezMTxwc8fyXpqWVBBAE5Wr5O7og&sensor=true');
	wp_enqueue_script('geocoding-metabox', get_template_directory_uri() . '/inc/metaboxes/geocode/geocode.js', array('jquery', 'google-maps-api'));
}

function geocoding_add_meta_box() {
	add_meta_box(
		'geocoding-address',
		'Endereço e geolocalização',
		'geocoding_inner_custom_box',
		'post',
		'advanced',
		'high'
	);
}

function geocoding_inner_custom_box($post) {
	$lat = get_post_meta($post->ID, 'geocode_latitude', true);
	$long = get_post_meta($post->ID, 'geocode_longitude', true);
	$address = get_post_meta($post->ID, 'geocode_address', true);
	$viewport = get_post_meta($post->ID, 'geocode_viewport', true);
	$instructions = get_post_meta($post->ID, 'geo_instructions', true);
	echo '<div id="geolocate">';
	echo '<h4>Escreva um endereço</h4>';
	echo '<p>';
	    echo '<input type="text" size="80" id="geocode_address" name="geocode_address" value="'.$address.'" />';
	    echo '<input type="button" onclick="codeAddress();" value="Geolocalizar" />';
	echo '</p>';
	echo '<div class="results"></div>';
	echo '<p>Arraste o marcador para obter um resultado mais preciso</p>';
	echo '<div id="geolocate_canvas" style="width:500px;height:300px"></div>';
	echo '<h4>Resultado:</h4>';
	echo '<p>';
	    echo 'Latitude: <input type="text" id="geocode_lat" name="geocode_lat" value="'.$lat.'" /><br/>';
	    echo 'Longitude: <input type="text" id="geocode_long" name="geocode_long" value="'.$long.'" />';
	echo '</p>';
	echo '<input type="hidden" id="geocode_viewport" name="geocode_viewport" value="'.$viewport.'" />';
	echo '</div>';
	echo '
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$("#geolocate_canvas").geolocate();
		});
	</script>
	<style>
	    #geocoding-address .results ul li {
	        cursor: pointer;
	        text-decoration: underline;
	    }
	    #geocoding-address .results ul li.active {
	        cursor: default;
	        text-decoration: none;
	    }
	</style>
	';
}

function geocoding_save_postdata($post_id) {
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (defined('DOING_AJAX') && DOING_AJAX)
		return;

	if (false !== wp_is_post_revision($post_id))
		return;

	update_post_meta($post_id, 'geocode_latitude', $_POST['geocode_lat']);
	update_post_meta($post_id, 'geocode_longitude', $_POST['geocode_long']);
	update_post_meta($post_id, 'geocode_viewport', $_POST['geocode_viewport']);
	update_post_meta($post_id, 'geocode_address', $_POST['geocode_address']);
}

?>