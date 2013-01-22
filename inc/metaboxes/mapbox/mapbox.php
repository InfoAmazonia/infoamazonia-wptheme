<?php

add_action('admin_footer', 'mapbox_metabox_init');
add_action('add_meta_boxes', 'mapbox_add_meta_box');
add_action('save_post', 'mapbox_save_postdata');

function mapbox_metabox_init() {
	// javascript stuff for the metabox
	wp_enqueue_script('mapbox-metabox', get_template_directory_uri() . '/inc/metaboxes/mapbox/mapbox.js', array('jquery', 'mapbox'));
	wp_enqueue_style('mapbox-metabox', get_template_directory_uri() . '/inc/metaboxes/mapbox/mapbox.css');

	wp_localize_script('mapbox-metabox', 'mapbox_metabox_localization', array(
		'remove_layer' => __('Remove layer', 'infoamazonia')
		)
	);
}

function mapbox_add_meta_box() {
	// register the metabox
	add_meta_box(
		'mapbox', // metabox id
		__('MapBox Setup', 'infoamazonia'), // metabox title
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
	$centerzoom = get_post_meta($post->ID, 'map_centerzoom', true);
	$pan_limits = get_post_meta($post->ID, 'map_pan_limits', true);
	?>
	<div id="mapbox-metabox">
		<h4><?php _e('Setup your map', 'infoamazonia'); ?></h4>
		<p><?php _e('Map server'); ?>: <input type="text" value="<?php echo $server; ?>" name="map_server" size="50" /></p>
		<h4><?php _e('Edit the default layer and fill the IDs of the maps to overlay layers of your map, in order of appearance', 'infoamazonia'); ?></h4>
		<div class="layers-container">
			<ol class="layers-list">
			<?php if(!$layers) { ?>
				<li><input type="text" name="map_layers[]" value="examples.map-vyofok3q" size="50" /></li>
			<?php } else {
				foreach($layers as $layer) { ?>
					<li><input type="text" name="map_layers[]" value="<?php echo $layer; ?>" size="50" /> <a href="#" class="button remove-layer"><?php _e('Remove layer', 'infoamazonia'); ?></a></li>
				<?php }
			} ?>
			</ol>
			<p><a class="button add-layer" href="#"><?php _e('Add new layer', 'infoamazonia'); ?></a></p>
			<p><a class="button-primary preview-map" href="#"><?php _e('Update preview', 'infoamazonia'); ?></a></p>
		</div>
		<div class="map-container">
			<h3><?php _e('Preview map', 'infoamazonia'); ?></h3>
			<div id="map_preview"></div>
		</div>
		<div class="map-visual-settings clearfix">
			<h3><?php _e('Visual settings', 'infoamazonia'); ?></h3>
			<div class="current map-setting">
				<h4><?php _e('Currently viewing', 'infoamazonia'); ?></h4>
				<table>
					<tr>
						<td><?php _e('Center', 'infoamazonia'); ?></td>
						<td><span class="center"></span></td>
					</tr>
					<tr>
						<td><?php _e('Zoom', 'infoamazonia'); ?></td>
						<td><span class="zoom"></span></td>
					</tr>
					<tr>
						<td><?php _e('East', 'infoamazonia'); ?></td>
						<td><span class="east"></span></td>
					</tr>
					<tr>
						<td><?php _e('North', 'infoamazonia'); ?></td>
						<td><span class="north"></span></td>
					</tr>
					<tr>
						<td><?php _e('South', 'infoamazonia'); ?></td>
						<td><span class="south"></span></td>
					</tr>
					<tr>
						<td><?php _e('West', 'infoamazonia'); ?></td>
						<td><span class="west"></span></td>
					</tr>
				</table>
			</div>
			<div class="centerzoom map-setting">
				<h4><?php _e('Map center & zoom', 'infoamazonia'); ?></h4>
				<p><a class="button set-map-centerzoom"><?php _e('Set current as map center & zoom', 'infoamazonia'); ?></a></p>
				<table>
					<tr>
						<td><?php _e('Center', 'infoamazonia'); ?></td>
						<td><span class="center">(<?php echo $centerzoom['center']['lat']; ?>, <?php echo $centerzoom['center']['lon']; ?>)</span></td>
					</tr>
					<tr>
						<td><?php _e('Zoom', 'infoamazonia'); ?></td>
						<td><span class="zoom"><?php echo $centerzoom['zoom']; ?></span></td>
					</tr>
				</table>
				<input type="hidden" class="center-lat" name="map_centerzoom[center][lat]" value="<?php echo $centerzoom['center']['lat']; ?>" />
				<input type="hidden" class="center-lon" name="map_centerzoom[center][lon]" value="<?php echo $centerzoom['center']['lon']; ?>" />
				<input type="hidden" class="zoom" name="map_centerzoom[zoom]" value="<?php echo $centerzoom['zoom']; ?>" />
			</div>
			<div class="pan-limits map-setting">
				<h4><?php _e('Pan limits', 'infoamazonia'); ?></h4>
				<p><a class="button set-map-pan"><?php _e('Set current as map panning limits', 'infoamazonia'); ?></a></p>
				<table>
					<tr>
						<td><?php _e('East', 'infoamazonia'); ?></td>
						<td><span class="east"><?php echo $pan_limits['east']; ?></span></td>
					</tr>
					<tr>
						<td><?php _e('North', 'infoamazonia'); ?></td>
						<td><span class="north"><?php echo $pan_limits['north']; ?></span></td>
					</tr>
					<tr>
						<td><?php _e('South', 'infoamazonia'); ?></td>
						<td><span class="south"><?php echo $pan_limits['south']; ?></span></td>
					</tr>
					<tr>
						<td><?php _e('West', 'infoamazonia'); ?></td>
						<td><span class="west"><?php echo $pan_limits['west']; ?></span></td>
					</tr>
				</table>
				<input type="hidden" class="east" name="map_pan_limits[east]" value="<?php echo $pan_limits['east']; ?>" />
				<input type="hidden" class="north" name="map_pan_limits[north]" value="<?php echo $pan_limits['north']; ?>" />
				<input type="hidden" class="south" name="map_pan_limits[south]" value="<?php echo $pan_limits['south']; ?>" />
				<input type="hidden" class="west" name="map_pan_limits[west]" value="<?php echo $pan_limits['west']; ?>" />
			</div>
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
	update_post_meta($post_id, 'map_centerzoom', $_POST['map_centerzoom']);
	update_post_meta($post_id, 'map_pan_limits', $_POST['map_pan_limits']);
}