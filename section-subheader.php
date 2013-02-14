<div class="subheader">

	<div class="choose-filter">
		<?php
		$publishers = get_terms('publisher');
		$title = '<span class="title">' . __('Choose a publisher', 'infoamazonia') . '</span>';
		$current_publisher = false;
		if(is_tax('publisher')) {
			$current_publisher = get_query_var('publisher');
			$current_publisher = get_term_by('slug', $publisher, 'publisher');
			$title = '<h2 class="title">' . $current_publisher->name . '</h2>';
		}
		if($publishers) : ?>
			<div class="box">
				<div class="clearfix">
					<span class="arrow"></span>
					<?php echo $title; ?>
				</div>
			</div>
			<ul>
				<?php if($current_publisher) : ?>
					<li class="filter"><a href="<?php echo home_url('/'); ?>" title="<?php _e('All stories', 'infoamazonia'); ?>"><?php _e('All stories', 'infoamazonia'); ?></a></li>
				<?php endif; ?>
				<?php foreach($publishers as $publisher) : ?>
					<?php if($current_publisher && $publisher->slug == $current_publisher->slug) continue; ?>
					<li class="filter"><a href="<?php echo get_term_link($publisher); ?>" title="<?php echo $publisher->name; ?>"><?php echo $publisher->name; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('#stage .choose-filter .box').toggle(function() {
						$(this).parent().addClass('active');
					}, function() {
						$(this).parent().removeClass('active');
					});
				});
			</script>
		<?php endif; ?>
	</div>

	<div class="clearfix">
		<?php get_search_form(); ?>
	</div>

</div>