<?php

/*
 * Geocode box
 */

function infoamazonia_geocode_box_scripts() {
	wp_enqueue_script('geocode-box', get_stylesheet_directory_uri() . '/js/geocode-box.js', array('jquery', 'mappress.geocode.box'), '0.0.1');
}
add_action('wp_enqueue_scripts', 'infoamazonia_geocode_box_scripts');

add_action('wp_footer', 'infoamazonia_geocode_box');
function infoamazonia_geocode_box() {
	?>
	<div id="geocode-box">
		<div class="geocode-box-container">
			<div id="geolocate">
				<h4><?php _e('Write an address', 'infoamazonia'); ?></h4>
				<p>
					<input type="text" size="80" id="geocode_address" name="geocode_address" />
				    <a class="button" href="#" onclick="codeAddress();return false;"><?php _e('Geolocate', 'infoamazonia'); ?></a>
				</p>
				<div class="results"></div>
				<div id="geolocate_canvas"></div>
				<h4><?php _e('Result', 'infoamazonia'); ?>:</h4>
				<p>
				    <?php _e('Latitude', 'infoamazonia'); ?>:
				    <input type="text" id="geocode_lat" name="geocode_latitude" /><br/>

				    <?php _e('Longitude', 'infoamazonia'); ?>:
				    <input type="text" id="geocode_lon" name="geocode_longitude" />
				</p>
				<input type="hidden" id="geocode_viewport" name="geocode_viewport" />
			</div>
			<p><a class="button finish-geocode-box" href="#"><?php _e('Finish geocoding', 'infoamazonia'); ?></a></p>
		</div>
	</div>
	<?php
}