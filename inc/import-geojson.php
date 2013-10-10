<?php

function import_geojson() {
	if(isset($_GET['import_geojson'])) {

		$geojson = array();
		//$geojson = get_transient('imported_geojson');
	
		if(!$geojson) {

			$json_urls = array(
				'en' => 'http://dev.cardume.art.br/infoamazonia/geojson/stories-en.geojson',
				'pt' => 'http://dev.cardume.art.br/infoamazonia/geojson/stories-pt.geojson',
				'es' => 'http://dev.cardume.art.br/infoamazonia/geojson/stories-es.geojson'
			);

			$options = array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => array('Content-type: application/json')
			);

			foreach($json_urls as $k => $url) {
				$ch = curl_init($url);
				curl_setopt_array($ch, $options);
				$result = curl_exec($ch);

				$geojson[$k] = json_decode($result, true);

				curl_close($ch);
			}

			//set_transient('imported_geojson', $geojson, 60*60*12);
		}

		$posts = array();
		foreach($geojson as $lang_key => $langs) {

			$lang_start = '<!--:' . $lang_key . '-->';
			$lang_finish = '<!--:-->';

			foreach($langs['features'] as $f) {

				$post_id = $f['properties']['id'];

				$post['post'] = array();
				$post['post']['post_type'] = 'post';
				$post['post']['post_status'] = 'publish';
				$post['post']['post_title'] = $lang_start . $f['properties']['title'] . $lang_finish;
				$post['post']['post_content'] = $lang_start . $f['properties']['story'] . $lang_finish;

				// fix buggy dates....
				$date = split('/', $f['properties']['date']);
				if(strlen($date[0]) == 1) {
					$date[0] = '0' . $date[0];
				}
				if(strlen($date[1]) == 1) {
					$date[1] = '0' . $date[1];
				}
				if(strlen($date[2]) == 2) {
					$date[2] = '20' . $date[2];
				}
				$date = $date[2] . '-' . $date[1] . '-' . $date[0];

				$post['post']['post_date'] = $date;
				$post['post']['post_date_gmt'] = $date;
				$post['post']['tags_input'] = $f['properties']['tags'];
				$post['meta'] = array();
				$post['meta']['url'] = $f['properties']['url'];
				$post['meta']['picture'] = $f['properties']['picture'];
				$post['meta']['reporter'] = $f['properties']['reporter'];
				$post['meta']['geocode_address'] = $f['properties']['location'];
				$post['meta']['geocode_latitude'] = $f['geometry']['coordinates'][1];
				$post['meta']['geocode_longitude'] = $f['geometry']['coordinates'][0];
				$post['tax'] = array();
				$post['tax']['publisher'] = $f['properties']['source'];

				if(!isset($posts[$post_id])) {

					$posts[$post_id] = $post;

				} else {

					$posts[$post_id]['post']['post_title'] .= $post['post']['post_title'];
					$posts[$post_id]['post']['post_content'] .= $post['post']['post_content'];

				}

			}
		}

		$i = 0;
		foreach($posts as $post) {

			//if($i == 5) break;

			$post_id = false;
			$post_id = wp_insert_post($post['post']);

			if($post_id) {

				// meta data
				foreach($post['meta'] as $key => $value) {
					update_post_meta($post_id, $key, $value);
				}

				// tax
				foreach($post['tax'] as $tax => $term) {

					// check term
					$term_obj = get_term_by('name', $term, $tax);

					if(!$term_obj) {
						$term_id = wp_insert_term($term, $tax);
						$term_id = $term_id['term_id'];
					} else {
						$term_id = intval($term_obj->term_id);
					}

					// set term
					wp_set_object_terms($post_id, $term_id, $tax);
				}

			}

			$i++;

		}

		echo 'done.';

		exit;
	}
}
//add_action('init', 'import_geojson');