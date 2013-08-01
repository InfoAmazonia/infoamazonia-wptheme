<?php

/*
 * Geocode box
 */

function infoamazonia_geocode_box_scripts() {
	wp_enqueue_script('geocode-box', get_stylesheet_directory_uri() . '/js/geocode-box.js', array('jquery', 'mappress.geocode.box'), '0.0.2');
}
add_action('wp_enqueue_scripts', 'infoamazonia_geocode_box_scripts');

add_action('wp_footer', 'infoamazonia_geocode_box');
function infoamazonia_geocode_box() {
	?>
	<div id="geocode-box">
		<div class="geocode-box-container">
			<?php mappress_geocode_box(); ?>
			<p><a class="button finish-geocode-box" href="#"><?php _e('Finish geocoding', 'infoamazonia'); ?></a></p>
		</div>
	</div>
	<?php
}