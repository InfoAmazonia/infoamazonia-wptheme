<?php

/*
 * Submit story
 */

add_action('wp_footer', 'ekuatorial_submit');
function ekuatorial_submit() {
	?>
	<div id="submit-story">
		<div class="submit-container">
			<div class="submit-area">
				<a href="#" class="close-submit-story" title="<?php _e('Close', 'ekuatorial'); ?>">×</a>
				<h2><?php _e('Submit a story', 'ekuatorial'); ?></h2>
				<p class="description"><?php _e('Do you have news to share from the Amazon? Contribute to this map by submitting your story. Help broaden the understanding of the global impact of this important region in the world.', 'ekuatorial'); ?></p>
				<div class="submit-content">
					<div class="error"></div>
					<div class="choice">
						<div class="story-type">
							<a href="#" data-choice="submit-story-url" class="button"><?php _e('Submit a url', 'ekuatorial'); ?></a>
							<a href="#" data-choice="submit-story-full" class="button"><?php _e('Submit full story', 'ekuatorial'); ?></a>
						</div>
					</div>
					<form id="submit-story-full" class="submit-choice-content">
						<input type="hidden" name="action" value="ekuatorial_submit" />
						<p>
							<label for="story_author_full_name"><?php _e('Your full name', 'ekuatorial'); ?> <span class="required">*</span></label>
							<input type="text" name="story[meta][author_name]" id="story_author_full_name" size="30" />
						</p>
						<p>
							<label for="story_author_email"><?php _e('E-mail', 'ekuatorial'); ?> <span class="required">*</span></label>
							<input type="text" name="story[meta][author_email]" id="story_author_email" size="35" />
						</p>
						<p>
							<label for="story_reporter"><?php _e('Reporter', 'ekuatorial'); ?></label>
							<input type="text" name="story[meta][reporter]" id="story_reporter" size="30" />
						</p>
						<p>
							<label for="story_title"><?php _e('Story title', 'ekuatorial'); ?> <span class="required">*</span></label>
							<input type="text" name="story[post][post_title]" id="story_title" size="30" />
						</p>
						<p>
							<label for="story_content"><?php _e('Story text', 'ekuatorial'); ?></label>
							<textarea name="story[post][post_content]" id="story_content" rows="7" cols="50"></textarea>
						</p>
						<p>
							<label for="story_url"><?php _e('Story url', 'ekuatorial'); ?></label>
							<input type="text" name="story[meta][url]" id="story_url" size="60" />
						</p>
						<p>
							<label for="story_picture"><?php _e('Lead picture', 'ekuatorial'); ?></label>
							<input type="text" name="story[meta][picture]" id="story_picture" size="60" />
						</p>
						<div class="geocode">
							<p>
								<label for="story_location"><?php _e('Story location', 'ekuatorial'); ?></label>
								<input type="text" name="story[meta][geocode_address]" id="story_location" class="geocoded-address" size="40" />
								<a class="button open-geocode-box" href="#"><?php _e('Find location on map', 'ekuatorial'); ?></a>
								<div class="geocode-result" style="display:none;">
									<input type="hidden" name="story[meta][geocode_latitude]" class="geocoded-latitude" />
									<input type="hidden" name="story[meta][geocode_longitude]" class="geocoded-longitude" />
									<p>
										<?php _e('Latitude:', 'ekuatorial'); ?> <span class="geocoded-latitude"></span><br/>
										<?php _e('Longitude:', 'ekuatorial'); ?> <span class="geocoded-longitude"></span>
									</p>
								</div>
								<script type="text/javascript">
									jQuery(document).ready(function($) { $('#submit-story .geocode').ekuatorialGeocodeBox(); });
								</script>
							</p>
						</div>
						<p>
							<label for="story_date"><?php _e('Publishing date', 'ekuatorial'); ?></label>
							<input type="text" name="story[meta][publish_date]" id="story_date" size="20" />
						</p>
						<p>
							<label for="story_notes"><?php _e('Notes to the ekuatorial editor', 'ekuatorial'); ?></label>
							<textarea name="story[meta][notes]" id="story_notes" rows="7" cols="50"></textarea>
						</p>
						<input class="button" type="submit" value="<?php _e('Send story', 'ekuatorial'); ?>" />
					</form>
					<form id="submit-story-url" class="submit-choice-content">
						<input type="hidden" name="action" value="ekuatorial_submit" />
						<p>
							<label for="story_full_name"><?php _e('Your full name', 'ekuatorial'); ?> <span class="required">*</span></label>
							<input type="text" name="story[meta][author_name]" id="story_full_name" size="30" />
						</p>
						<p>
							<label for="story_email"><?php _e('E-mail', 'ekuatorial'); ?> <span class="required">*</span></label>
							<input type="text" name="story[meta][author_email]" id="story_email" size="35" />
						</p>
						<p>
							<label for="story_url"><?php _e('Story url', 'ekuatorial'); ?></label>
							<input type="text" name="story[meta][url]" id="story_url" size="60" />
						</p>
						<div class="geocode">
							<p>
								<label for="story_location"><?php _e('Story location', 'ekuatorial'); ?></label>
								<input type="text" name="story[meta][geocode_address]" id="story_location" class="geocoded-address" size="40" />
								<a class="button open-geocode-box" href="#"><?php _e('Find location on map', 'ekuatorial'); ?></a>
								<div class="geocode-result" style="display:none;">
									<input type="hidden" name="story[meta][geocode_latitude]" class="geocoded-latitude" />
									<input type="hidden" name="story[meta][geocode_longitude]" class="geocoded-longitude" />
									<p>
										<?php _e('Latitude:', 'ekuatorial'); ?> <span class="geocoded-latitude"></span><br/>
										<?php _e('Longitude:', 'ekuatorial'); ?> <span class="geocoded-longitude"></span>
									</p>
								</div>
								<script type="text/javascript">
									jQuery(document).ready(function($) { $('#submit-story .geocode').ekuatorialGeocodeBox(); });
								</script>
							</p>
						</div>
						<input class="button" type="submit" value="<?php _e('Send story', 'ekuatorial'); ?>" />
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
}

add_action('wp_ajax_nopriv_ekuatorial_submit', 'ekuatorial_submit_post');
add_action('wp_ajax_ekuatorial_submit', 'ekuatorial_submit_post');
function ekuatorial_submit_post() {
	$story = $_GET['story'];
	$return = array();

	$post = $story['post'];
	$post['post_status'] = 'pending';
	if(!isset($post['post_title']))
		$post['post_title'] = 'Submission by ' . $story['meta']['author_name'];

	if(!$story['meta']['author_name'] || !$story['meta']['author_email'])
		return json_death(array('error' => __('Missing information. Please fill all the required fields!', 'ekuatorial')));

	$post_id = wp_insert_post($post);
	if($post_id) {
		foreach($story['meta'] as $meta => $value) {
			update_post_meta($post_id, $meta, $value);
		}
		$return['post_id'] = $post_id;
	} else {
		$return['error'] = __('Could not save submission', 'ekuatorial');
	}

	header('Content Type: application/json');
	echo json_encode($return);
	exit;
}

function json_death($o) {
	header('Content Type: application/json');
	echo json_encode($o);
	exit;
}