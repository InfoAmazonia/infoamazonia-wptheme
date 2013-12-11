<?php
class CategoryFeedsWidget extends WP_Widget {

	function CategoryFeedsWidget() {
		$widget_ops = array('classname' => 'widget_category_feeds', 'description' => __('RSS Feeds by selected categories', 'ekuatorial') );
		$this->WP_Widget('CategoryFeedsWidget', __('Category Feed Links', 'ekuatorial'), $widget_ops);
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('RSS Feeds', 'ekuatorial'), 'categories' => '' ) );
		$title = $instance['title'];
		$categories = $instance['categories'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ekuatorial'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories separated by comma', 'ekuatorial'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" type="text" value="<?php echo attribute_escape($categories); ?>" /></label></p>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['categories'] = $new_instance['categories'];
		return $instance;
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', __($instance['title']));
		$categories = $instance['categories'];

		echo $before_widget;

		echo $before_title . $title . $after_title;

		echo '<ul class="categories">';
			if(!$categories) {
				$category_ids = get_all_category_ids();
			} else {
				$category_ids = explode(',', $categories);
			}
			foreach($category_ids as $cat_id) {
				echo '<li><a href="' . get_category_feed_link($cat_id) . '" title="' . __('RSS Feed', 'ekuatorial') . '" target="_blank">' . get_cat_name($cat_id) . '</a></li>';
			}
		echo '</ul>';

		echo $after_widget;
	}

}
add_action( 'widgets_init', create_function('', 'return register_widget("CategoryFeedsWidget");') );
?>