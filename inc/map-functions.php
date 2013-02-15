<?php

function mappress_setup() {
	// register map and map group post types
	include(TEMPLATEPATH . '/inc/map-post-types.php');

	add_theme_support('post-thumbnails');
	add_image_size('post-thumb', 245, 90, true);
}
add_action('after_setup_theme', 'mappress_setup');

/*
 * Register/enqueue scripts & styles
 */
function mappress_scripts() {
	wp_register_script('underscore', get_template_directory_uri() . '/lib/underscore-min.js', array(), '1.4.3');
	wp_register_script('mapbox-js', get_template_directory_uri() . '/lib/mapbox.js', array(), '0.6.7');
	wp_enqueue_style('mapbox', get_template_directory_uri() . '/lib/mapbox.css', array(), '0.6.7');

	wp_register_script('d3js', get_template_directory_uri() . '/lib/d3.v2.min.js', array('jquery'), '3.0.5');

	wp_enqueue_script('mappress', get_template_directory_uri() . '/js/mappress.js', array('mapbox-js', 'underscore', 'jquery'), '0.0.7.4');
	wp_enqueue_script('mappress.hash', get_template_directory_uri() . '/js/mappress.hash.js', array('mappress', 'underscore'), '0.0.1.9');
	wp_enqueue_script('mappress.geocode', get_template_directory_uri() . '/js/mappress.geocode.js', array('mappress', 'd3js', 'underscore'), '0.0.2.4');
	wp_enqueue_script('mappress.filterLayers', get_template_directory_uri() . '/js/mappress.filterLayers.js', array('mappress', 'underscore'), '0.0.5');
	wp_enqueue_script('mappress.groups', get_template_directory_uri() . '/js/mappress.groups.js', array('mappress', 'underscore'), '0.0.3.27');
	wp_enqueue_script('mappress.markers', get_template_directory_uri() . '/js/mappress.markers.js', array('mappress', 'underscore'), '0.0.2.59');
	wp_enqueue_script('mappress.submit', get_template_directory_uri() . '/js/mappress.submit.js', array('jquery'), '0.0.2');

	wp_enqueue_style('mappress', get_template_directory_uri() . '/css/mappress.css', array(), '0.0.1.1');

	wp_localize_script('mappress', 'mappress_localization', array(
		'ajaxurl' => admin_url('admin-ajax.php?lang=' . qtrans_getLanguage()),
		'more_label' => __('More', 'infoamazonia')
		)
	);

	wp_localize_script('mappress.geocode', 'mappress_labels', array(
		'search_placeholder' => __('Find a location', 'infoamazonia'),
		'results_title' => __('Results', 'infoamazonia'),
		'clear_search' => __('Clear search', 'infoamazonia')
		)
	);

	wp_localize_script('mappress.groups', 'mappress_groups', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'more_label' => __('More', 'infoamazonia')
		)
	);

	wp_localize_script('mappress.markers', 'mappress_markers', array(
		'ajaxurl' => admin_url('admin-ajax.php?lang=' . qtrans_getLanguage()),
		'query' => mappress_get_marker_query_args(),
		'stories_label' => __('stories', 'infoamazonia'),
		'home' => is_front_page()
		)
	);
}
add_action('wp_enqueue_scripts', 'mappress_scripts');

// marker query args

function mappress_get_marker_query_args($posts_per_page = -1) {
	global $post;
	if(is_singular(array('map', 'map-group'))) {
		$query = array('post_type' => 'post');
		// map exclusive post query
		if(is_singular('map')) {
			$query['meta_query'] = array(
				'relation' => 'OR',
				array(
					'key' => 'maps',
					'value' => $post->ID,
					'compare' => 'LIKE'
				),
				array(
					'key' => 'has_maps',
					'value' => null,
					'compare' => 'NOT EXISTS'
				)
			);
		} else  {
			$groupdata = get_post_meta($post->ID, 'mapgroup_data', true);
			$meta_query = array('relation' => 'OR');
			$i = 1;
			foreach($groupdata['maps'] as $map) {
				$meta_query[$i] = array(
					'key' => 'maps',
					'value' => intval($map['id']),
					'compare' => 'LIKE'
				);
				$i++;
			}
			$meta_query[$i] = array(
				'key' => 'has_maps',
				'value' => null,
				'compare' => 'NOT EXISTS'
			);
			$query['meta_query'] = $meta_query;
		}
	} else {
		global $wp_query;
		$query = $wp_query->query_vars;
	}
	$query['posts_per_page'] = $posts_per_page;
	if($posts_per_page == -1 && isset($query['paged']))
		unset($query['paged']);
	else 
		$query['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
	return $query;
}

// disable canonical redirect on map/map-group post type for stories pagination
add_filter('redirect_canonical', 'mappress_disable_canonical');
function mappress_disable_canonical($redirect_url) {
	if(is_singular('map') || is_singular('map-group'))
		return false;
}

// display map

function mappress_map($post_id = false) {
	global $post;
	$post_id = $post_id ? $post_id : $post->ID;
	if(!$post_id)
		return;
	setup_postdata(get_post($post_id));
	get_template_part('content', 'map');
	wp_reset_postdata();
}

/*
 * Map groups
 */

// display map group

function mappress_mapgroup($post_id = false) {
	global $post;
	$post_id = $post_id ? $post_id : $post->ID;
	if(!$post_id)
		return;
	setup_postdata(get_post($post_id));
	get_template_part('content', 'map-group');
	wp_reset_postdata();
}

// get data

add_action('wp_ajax_nopriv_mapgroup_data', 'mappress_get_mapgroup_json_data');
add_action('wp_ajax_mapgroup_data', 'mappress_get_mapgroup_json_data');
function mappress_get_mapgroup_json_data($group_id = false) {
	$group_id = $group_id ? $group_id : $_REQUEST['group_id'];
	$data = json_encode(mappress_get_mapgroup_data($group_id));
	header('Content Type: application/json');
	echo $data;
	exit;
}

function mappress_get_mapgroup_data($group_id) {
	global $post;
	$group_id = $group_id ? $group_id : $post->ID;
	$data = array();
	if(get_post_type($group_id) != 'map-group')
		return;
	$group_data = get_post_meta($group_id, 'mapgroup_data', true);
	foreach($group_data['maps'] as $map) {
		$map_id = 'map_' . $map['id'];
		$data['maps'][$map_id] = mappress_get_map_data($map['id']);
	}
	return $data;
}

add_action('wp_ajax_nopriv_map_data', 'mappress_get_map_json_data');
add_action('wp_ajax_map_data', 'mappress_get_map_data_json_data');
function mappress_get_map_json_data($map_id = false) {
	$map_id = $map_id ? $map_id : $_REQUEST['map_id'];
	$data = json_encode(mappress_get_map_data($map_id));
	header('Content Type: application/json');
	echo $data;
	exit;
}

function mappress_get_map_data($map_id = false) {
	global $post;
	$map_id = $map_id ? $map_id : $post->ID;
	if(get_post_type($map_id) != 'map')
		return;
	$post = get_post($map_id);
	setup_postdata($post);
	$data = get_post_meta($map_id, 'map_data', true);
	$data['title'] = get_the_title($map_id);
	$data['legend'] = get_post_meta($map_id, 'legend', true);
	$data['legend_full'] = '<h2>' . $data['title'] . '</h2>' .  apply_filters('the_content', get_the_content());
	wp_reset_postdata();
	return $data;
}

/*
 * Markers
 */

add_action('wp_ajax_nopriv_markers_geojson', 'mappress_get_markers_data');
add_action('wp_ajax_markers_geojson', 'mappress_get_markers_data');
function mappress_get_markers_data() {
	$query = $_REQUEST['query'];

	$query_id = md5(serialize($query));

	$data = false;
	$transient = $query_id . '_geojson';

	if($_REQUEST['lang'])
		$transient .= '_' . $_REQUEST['lang'];

	//$data = get_transient($transient);

	if($data === false) {

		$data = array();

		$posts = get_posts($query);

		if($posts) {
			global $post;
			$data['type'] = 'FeatureCollection';
			$data['features'] = array();
			$i = 0;
			foreach($posts as $post) {

				setup_postdata($post);

				$data['features'][$i]['type'] = 'Feature';

				$data['features'][$i]['geometry'] = array();
				$data['features'][$i]['geometry']['type'] = 'Point';

				$latitude = get_post_meta($post->ID, 'geocode_latitude', true);
				$longitude = get_post_meta($post->ID, 'geocode_longitude', true);

				if($latitude && $longitude)
					$data['features'][$i]['geometry']['coordinates'] = array($longitude, $latitude);
				else
					$data['features'][$i]['geometry']['coordinates'] = array(0, 0);

				$data['features'][$i]['properties'] = array();
				$data['features'][$i]['properties']['id'] = 'post-' . $post->ID;
				$data['features'][$i]['properties']['title'] = get_the_title();
				$data['features'][$i]['properties']['date'] = get_the_orig_date(_x('m/d/Y', 'reduced date format', 'infoamazonia'));
				$data['features'][$i]['properties']['story'] = apply_filters('the_content', get_the_content());
				$data['features'][$i]['properties']['url'] = get_post_meta($post->ID, 'url', true);

				// source
				$publishers = get_the_terms($post->ID, 'publisher');
				if($publishers) {
					$publisher = array_shift($publishers);
					$data['features'][$i]['properties']['source'] = $publisher->name;
				}

				// thumbnail
				$thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumb');
				if($thumb_src)
					$data['features'][$i]['properties']['thumbnail'] = $thumb_src[0];
				else {
					$data['features'][$i]['properties']['thumbnail'] = get_post_meta($post->ID, 'picture', true);
				}

				// maps
				$maps = get_post_meta($post->ID, 'maps');
				if($maps && !empty($maps)) {
					foreach($maps as $map) {
						$data['features'][$i]['properties']['maps'][] = $map;
					}
				}

				$i++;

				wp_reset_postdata();
			}
		}
		$data['query_id'] = $query_id;
		$data = json_encode($data);
		set_transient($transient, $data, 60*60*1);
	}

	/*
	$expires = 60 * 15; // 15 minutes of browser cache
	header('Pragma: public');
	header('Cache-Control: maxage=' . $expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
	header('Content Type: application/json');
	*/
	echo $data;
	exit;
}

add_action('wp_footer', 'mappress_submit');
function mappress_submit() {
	?>
	<div id="submit-story">
		<div class="submit-container">
			<div class="submit-area">
				<h2><?php _e('Submit a story', 'infoamazonia'); ?></h2>
				<div class="choice">
					<p><?php _e('Do you have news to share from the Amazon? Contribute to this map by submitting your story. Help broaden the understanding of the global impact of this important region in the world.', 'infoamazonia'); ?></p>
					<div class="story-type">
						<a href="#" class="submit-story-url button"><?php _e('Submit a url', 'infoamazonia'); ?></a>
						<a href="#" class="submit-story-full button"><?php _e('Submit full story', 'infoamazonia'); ?></a>
					</div>
				</div>
				<?php /*
				<form id="submit-story-full">
				</form>
				<form id="submit-story-url">
					<label for="full_name"><?php _e('Your full name', 'infoamazonia'); ?></label>
					<input type="text" id="full_name" />
				</form>
				*/ ?>
				<a href="#" class="close-submit-story"><?php _e('Close', 'infoamazonia'); ?></a>
			</div>
		</div>
	</div>
	<?php
}
?>