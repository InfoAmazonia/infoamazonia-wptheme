<?php

add_action('admin_footer', 'mapbox_metabox_init');
add_action('add_meta_boxes', 'mapbox_add_meta_box');
add_action('save_post', 'mapbox_save_postdata');

function mapbox_metabox_init() {
	// javascript stuff for the metabox
	wp_enqueue_script('mapbox-metabox', get_template_directory_uri() . '/inc/metaboxes/mapbox/mapbox.js', array('jquery', 'mappress'), '0.0.6');
	wp_enqueue_style('mapbox-metabox', get_template_directory_uri() . '/inc/metaboxes/mapbox/mapbox.css', array(), '0.0.6');

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
	$map_data = get_post_meta($post->ID, 'map_data', true);
	if(!isset($map_data['server']) || !$map_data['server'])
		$map_data['server'] = 'mapbox'; // default map service

	?>
	<div id="mapbox-metabox">
		<h4><?php _e('First, define your map server. Most likely you will be using the MapBox default servers. If not and you know what you are doing, feel free to type your own TileStream server url below.', 'infoamazonia'); ?></h4>
		<p>
			<input id="input_server_mapbox" type="radio" name="map_data[server]" value="mapbox" <?php if($map_data['server'] == 'mapbox') echo 'checked'; ?> /> <label for="input_server_mapbox"><strong><?php _e('Use MapBox servers', 'infoamazonia'); ?></strong> <i><?php _e('(default)', 'infoamazonia'); ?></i></label><br/>
			<input id="input_server_custom" type="radio" name="map_data[server]" value="custom" <?php if($map_data['server'] == 'custom') echo 'checked'; ?> /> <label for="input_server_custom"><?php _e('Use custom TileStream server', 'infoamazonia'); ?>: <input type="text" name="map_data[custom_server]" value="<?php if(isset($map_data['custom_server'])) echo $map_data['custom_server']; ?>" size="70" placeholder="http://maps.example.com/v2/" /></label>
		</p>
		<h4><?php _e('Edit the default layer and fill the IDs of the maps to overlay layers of your map, in order of appearance', 'infoamazonia'); ?></h4>
		<div class="layers-container">
			<ol class="layers-list">
			<?php if(!isset($map_data['layers'])) { ?>
				<li><input type="text" name="map_data[layers][]" value="examples.map-vyofok3q" size="50" /></li>
			<?php } else {
				foreach($map_data['layers'] as $layer) { ?>
					<li><input type="text" name="map_data[layers][]" value="<?php echo $layer; ?>" size="50" /> <a href="#" class="button remove-layer"><?php _e('Remove layer', 'infoamazonia'); ?></a></li>
				<?php }
			} ?>
			</ol>
			<p><a class="button add-layer" href="#"><?php _e('Add new layer', 'infoamazonia'); ?></a></p>
			<p><a class="button-primary preview-map" href="#"><?php _e('Update preview', 'infoamazonia'); ?></a></p>
		</div>
		<h3><?php _e('Preview map', 'infoamazonia'); ?></h3>
		<div class="map-container">
			<div id="map_preview"></div>
		</div>
		<div class="map-settings clearfix">
			<h3><?php _e('Map settings', 'infoamazonia'); ?></h3>
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
						<td><span class="center">(<?php if(isset($map_data['center'])) echo $map_data['center']['lat']; ?>, <?php if(isset($map_data['center'])) echo $map_data['center']['lon']; ?>)</span></td>
					</tr>
					<tr>
						<td><?php _e('Zoom', 'infoamazonia'); ?></td>
						<td><span class="zoom"><?php if(isset($map_data['zoom'])) echo $map_data['zoom']; ?></span></td>
					</tr>
					<tr>
						<td><label for="min-zoom-input"><?php _e('Min zoom', 'infoamazonia'); ?></label></td>
						<td>
							<input type="text" size="2" id="min-zoom-input" value="<?php if(isset($map_data['min_zoom'])) echo $map_data['min_zoom']; ?>" name="map_data[min_zoom]" />
							<a class="button set-min-zoom" href="#"><?php _e('Current', 'infoamazonia'); ?></a>
						</td>
					</tr>
					<tr>
						<td><label for="max-zoom-input"><?php _e('Max zoom', 'infoamazonia'); ?></label></td>
						<td>
							<input type="text" size="2" id="max-zoom-input" value="<?php if(isset($map_data['center'])) echo $map_data['max_zoom']; ?>" name="map_data[max_zoom]" />
							<a class="button set-max-zoom" href="#"><?php _e('Current', 'infoamazonia'); ?></a>
						</td>
					</tr>
				</table>
				<input type="hidden" class="center-lat" name="map_data[center][lat]" value="<?php if(isset($map_data['center'])) echo $map_data['center']['lat']; ?>" />
				<input type="hidden" class="center-lon" name="map_data[center][lon]" value="<?php if(isset($map_data['center'])) echo $map_data['center']['lon']; ?>" />
				<input type="hidden" class="zoom" name="map_data[zoom]" value="<?php if(isset($map_data['zoom'])) echo $map_data['zoom']; ?>" />
			</div>
			<div class="pan-limits map-setting">
				<h4><?php _e('Pan limits', 'infoamazonia'); ?></h4>
				<p><a class="button set-map-pan"><?php _e('Set current as map panning limits', 'infoamazonia'); ?></a></p>
				<table>
					<tr>
						<td><?php _e('East', 'infoamazonia'); ?></td>
						<td><span class="east"><?php if(isset($map_data['pan_limits'])) echo $map_data['pan_limits']['east']; ?></span></td>
					</tr>
					<tr>
						<td><?php _e('North', 'infoamazonia'); ?></td>
						<td><span class="north"><?php if(isset($map_data['pan_limits'])) echo $map_data['pan_limits']['north']; ?></span></td>
					</tr>
					<tr>
						<td><?php _e('South', 'infoamazonia'); ?></td>
						<td><span class="south"><?php if(isset($map_data['pan_limits'])) echo $map_data['pan_limits']['south']; ?></span></td>
					</tr>
					<tr>
						<td><?php _e('West', 'infoamazonia'); ?></td>
						<td><span class="west"><?php if(isset($map_data['pan_limits'])) echo $map_data['pan_limits']['west']; ?></span></td>
					</tr>
				</table>
				<input type="hidden" class="east" name="map_data[pan_limits][east]" value="<?php if(isset($map_data['pan_limits'])) echo $map_data['pan_limits']['east']; ?>" />
				<input type="hidden" class="north" name="map_data[pan_limits][north]" value="<?php if(isset($map_data['pan_limits'])) echo $map_data['pan_limits']['north']; ?>" />
				<input type="hidden" class="south" name="map_data[pan_limits][south]" value="<?php if(isset($map_data['pan_limits'])) echo $map_data['pan_limits']['south']; ?>" />
				<input type="hidden" class="west" name="map_data[pan_limits][west]" value="<?php if(isset($map_data['pan_limits'])) echo $map_data['pan_limits']['west']; ?>" />
			</div>
			<div class="geocode map-setting">
				<h4><?php _e('Enable geocoding service', 'infoamazonia'); ?></h4>
				<p>
					<input class="enable-geocode" id="enable_geocode" type="checkbox" name="map_data[geocode]" <?php if(isset($map_data['geocode']) && $map_data['geocode']) echo 'checked'; ?> />
					<label for="enable_geocode"><?php _e('Enable geocode search service'); ?></label>
				</p>
			</div>
		</div>
		<p>
			<a class="button-primary preview-map" href="#"><?php _e('Update preview', 'infoamazonia'); ?></a>
			<input type="checkbox" class="toggle-preview-mode" id="toggle_preview_mode" checked /> <label for="toggle_preview_mode"><strong><?php _e('Preview mode', 'infoamazonia'); ?></strong></label>
			<i><?php _e("(preview mode doesn't apply zoom range nor pan limits setup)", 'infoamazonia'); ?></i>
		</p>
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
	if(isset($_POST['map_data']))
		update_post_meta($post_id, 'map_data', $_POST['map_data']);
}