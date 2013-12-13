<?php

/*
 * infoamazonia slideshow
 */

// get content media
function infoamazonia_get_content_media($post_id = false, $force_update = false) {
	global $post;
	if($post_id)
		$post = get_post($post_id);

	$media = get_post_meta($post->ID, 'post_media', true);

	if(!$media || $force_update) {

		$content = apply_filters('the_content', $post->post_content);
		if($content) {
			$doc = new DOMDocument();
			
			$doc->loadHTML($content);

			$media = array();

			$imageTags = $doc->getElementsByTagName('img');
			if($imageTags->length) {
				$media['images'] = array();
				foreach($imageTags as $tag) {
					array_push($media['images'], $tag->getAttribute('src'));
				}
			}

			$iframeTags = $doc->getElementsByTagName('iframe');
			if($iframeTags->length) {
				$media['iframes'] = array();
				foreach($iframeTags as $tag) {
					$src = $tag->getAttribute('src');
					$type = $tag->getAttribute('data-type');
					$width = $tag->getAttribute('width');
					$height = $tag->getAttribute('height');

					if(!$type) $type = 'video';

					$media_content = array(
						'src' => $src,
						'width' => $width,
						'height' => $height,
						'type' => $type
					);

					array_push($media['iframes'], $media_content);
				}
			}

			if(empty($media))
				$media = 'no-media';

			update_post_meta($post->ID, 'post_media', $media);
		}
	}

	if($media == 'no-media')
		return false;

	return $media;
}

// get content without media
function infoamazonia_strip_content_media($post_id = false) {
	global $post;
	if($post_id)
		$post = get_post($post_id);

	$content = apply_filters('the_content', $post->post_content);
	return strip_tags($content, '<p><a><span><strong><i>');
}

function infoamazonia_update_content_media($post_id) {
	if(get_post_type($post_id) == 'post')
		infoamazonia_get_content_media($post_id, true);
}
add_action('save_post', 'infoamazonia_update_content_media');
?>