<?php

add_action('admin_footer', 'mapbox_init');
add_action('add_meta_boxes', 'mapbox_add_meta_box');
add_action('save_post', 'mapbox_save_postdata');

function mapbox_init() {
	wp_enqueue_script('geocoding-metabox', get_template_directory_uri() . '/inc/metaboxes/mapbox/mapbox.js', array('jquery'));
}

function mapbox_add_meta_box() {
	add_meta_box(
		'mapbox',
		'Mapas do MapBox',
		'mapbox_inner_custom_box',
		'map',
		'advanced',
		'high'
	);
}

function mapbox_inner_custom_box($post) {
	$server = get_post_meta($post->ID, 'map_server', true);
	if(!$server)
		$server = 'http://a.tiles.mapbox.com/v3/'; // default map service

	$layers = get_post_meta($post->ID, 'map_layers', true);

	?>
	<div id="mapbox-metabox">
		<h4>Configure seu mapa</h4>
		<p>Servidor de mapa: <input type="text" value="<?php echo $server; ?>" name="map_server" size="50" /></p>
		<h4>Preencha os IDs dos mapas para preenchimento das layers do seu mapa, na ordem de aparição</h4>
		<div class="layers-container">
			<ol class="layers-list">
			<?php if(!$layers) { ?>
				<li><input type="text" name="map_layers[]" /></li>
			<?php } else {
				foreach($layers as $layer) { ?>
					<li><input type="text" name="map_layers[]" value="<?php echo $layer; ?>" /> <a href="#" class="remove-layer" title="Remover layer">X</a></li>
				<?php }
			} ?>
			</ol>
			<p><a class="button add-layer" href="#">Adicionar nova layer</a></p>
		</div>
	</div>
	<?php
}

function mapbox_save_postdata($post_id) {
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (defined('DOING_AJAX') && DOING_AJAX)
		return;

	if (false !== wp_is_post_revision($post_id))
		return;

	update_post_meta($post_id, 'map_server', $_POST['map_server']);
	update_post_meta($post_id, 'map_layers', $_POST['map_layers']);
}