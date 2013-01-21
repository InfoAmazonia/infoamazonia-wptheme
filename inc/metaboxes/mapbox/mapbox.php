<?php

add_action('admin_footer', 'mapbox_metabox_init');
add_action('add_meta_boxes', 'mapbox_add_meta_box');
add_action('save_post', 'mapbox_save_postdata');

function mapbox_metabox_init() {
	// javascript stuff for the metabox
	wp_enqueue_script('mapbox-metabox', get_template_directory_uri() . '/inc/metaboxes/mapbox/mapbox.js', array('jquery')); // layers looping system there
}

function mapbox_add_meta_box() {
	// register the metabox
	add_meta_box(
		'mapbox', // metabox id
		'Mapas do MapBox', // metabox title
		'mapbox_inner_custom_box', // metabox inner code
		'map', // post type
		'advanced', // metabox position (advanced to show on main area)
		'high' // metabox priority (kind of an ordering)
	);
}

function mapbox_inner_custom_box($post) {
	// get previous data if any
	$server = get_post_meta($post->ID, 'map_server', true);
	if(!$server)
		$server = 'http://a.tiles.mapbox.com/v3/'; // default map service

	$layers = get_post_meta($post->ID, 'map_layers', true);
	?>
	<div id="mapbox-metabox">
		<h4><?php _e('Setup your map', 'infoamazonia'); ?></h4>
		<p><?php _e('Map server:'); ?>: <input type="text" value="<?php echo $server; ?>" name="map_server" size="50" /></p>
		<h4><?php _e('Fill the IDs of the maps to overlay layers of your map, in order of appearance', 'infoamazonia'); ?></h4>
		<div class="layers-container">
			<ol class="layers-list">
			<?php if(!$layers) { ?>
				<li><input type="text" name="map_layers[]" /></li>
			<?php } else {
				foreach($layers as $layer) { ?>
					<li><input type="text" name="map_layers[]" value="<?php echo $layer; ?>" /> <a href="#" class="remove-layer" title="<?php _e('Remove layer', 'infoamazonia'); ?>">X</a></li>
				<?php }
			} ?>
			</ol>
			<p><a class="button add-layer" href="#"><?php _e('Add new layer', 'infoamazonia'); ?></a></p>
		</div>
	</div>
	<?php
}

function mapbox_save_postdata($post_id) {
	// prevent data loss on autosave or any other ajaxed post update
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (defined('DOING_AJAX') && DOING_AJAX)
		return;

	if (false !== wp_is_post_revision($post_id))
		return;

	// save data
	update_post_meta($post_id, 'map_server', $_POST['map_server']);
	update_post_meta($post_id, 'map_layers', $_POST['map_layers']);
}