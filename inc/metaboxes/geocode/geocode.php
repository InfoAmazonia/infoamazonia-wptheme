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
		__('Address and geolocation', 'infoamazonia'),
		'geocoding_inner_custom_box',
		'post',
		'advanced',
		'high'
	);
}

function geocoding_inner_custom_box($post) {
	$geocode = get_post_meta($post->ID, 'geocode', true);
	?>
	<div id="geolocate">
	<h4><?php _e('Write an address', 'infoamazonia'); ?></h4>
	<p>
		<input type="text" size="80" id="geocode_address" name="geocode[address]" value="<?php if(isset($geocode['address'])) echo $geocode['address']; ?>" />
	    <a class="button" href="#" onclick="codeAddress();return false;"><?php _e('Geolocate', 'infoamazonia'); ?></a>
	</p>
	<div class="results"></div>
	<p><?php _e('Drag the marker for a more precise result', 'infoamazonia'); ?></p>
	<div id="geolocate_canvas" style="width:500px;height:300px"></div>
	<h4><?php _e('Result', 'infoamazonia'); ?>:</h4>
	<p>
	    <?php _e('Latitude', 'infoamazonia'); ?>:
	    <input type="text" id="geocode_lat" name="geocode[lat]" value="<?php if(isset($geocode['lat'])) echo $geocode['lat']; ?>" /><br/>

	    <?php _e('Longitude', 'infoamazonia'); ?>:
	    <input type="text" id="geocode_lon" name="geocode[lon]" value="<?php if(isset($geocode['lon'])) echo $geocode['lon']; ?>" />
	</p>
	<input type="hidden" id="geocode_viewport" name="geocode[viewport]" value="<?php if(isset($geocode['viewport'])) echo $geocode['viewport']; ?>" />
	</div>
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
	<?php
}

function geocoding_save_postdata($post_id) {
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (defined('DOING_AJAX') && DOING_AJAX)
		return;

	if (false !== wp_is_post_revision($post_id))
		return;

	if(isset($_POST['geocode']))
		update_post_meta($post_id, 'geocode', $_POST['geocode']);

}

?>