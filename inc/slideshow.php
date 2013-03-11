<?php

/*
 * Infoamazonia slideshow
 */

// get content media
function infoamazonia_get_content_media($post_id = false, $force_update = false) {
	global $post;
	if($post_id)
		$post = get_post($post_id);

	$media = get_post_meta($post->ID, 'post_media', true);

	if(!$media || $force_update) {

		$content = apply_filters('the_content', $post->post_content);
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
				array_push($media['iframes'], $tag->getAttribute('src'));
			}
		}

		if(empty($media))
			$media = 'no-media';

		update_post_meta($post->ID, 'post_media', $media);
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
	infoamazonia_get_content_media($post_id, true);
}
add_action('save_post', 'infoamazonia_update_content_media');
?>