<?php

add_action('add_meta_boxes', 'featured_add_meta_box');
add_action('save_post', 'featured_save_postdata');

function featured_add_meta_box() {
	add_meta_box(
		'featured',
		__('Featured post', 'infoamazonia'),
		'featured_inner_custom_box',
		'post',
		'advanced',
		'high'
	);
}

function featured_inner_custom_box($post) {
	$featured = get_post_meta($post->ID, 'featured', true);
	?>
	<div id="featured-metabox">
		<input type="checkbox" name="featured_post" value="1" id="featured_post_input" <?php if($featured) echo 'checked'; ?> /> <label for="featured_post_input"><?php _e('This post is featured', 'infoamazonia'); ?></label>
	</div>
	<?php
}

function featured_save_postdata($post_id) {
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (defined('DOING_AJAX') && DOING_AJAX)
		return;

	if (false !== wp_is_post_revision($post_id))
		return;

	if(isset($_POST['featured_post']))
		update_post_meta($post_id, 'featured', $_POST['featured_post']);
	else
		delete_post_meta($post_id, 'featured');

}

?>