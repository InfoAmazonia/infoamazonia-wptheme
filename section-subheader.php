<?php if(is_front_page() || is_tax('publisher')) : ?>
	<div class="clearfix">
		<div class="choose-filter">
			<?php
			$publishers = get_terms('publisher');
			$title = '<span class="title">' . __('Choose a publisher', 'infoamazonia') . '</span>';
			$current_publisher = false;
			if(is_tax('publisher')) {
				$current_publisher = get_query_var('publisher');
				$current_publisher = get_term_by('slug', $publisher, 'publisher');
				$title = '<h1 class="title">' . $current_publisher->name . '</h1>';
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
	</div>
<?php elseif(is_search()) : ?>

	<?php echo '<h1 class="title">' . __('Search results for: ', 'infoamazonia') . '"' . $_REQUEST['s'] . '"</h1>'; ?>

<?php elseif(is_category()) : ?>

	<h1 class="title"><?php single_cat_title(); ?></h1>

<?php
elseif(is_archive()) :
	if (is_day()) :
		printf('<h1 class="title">' . __('Daily Archives: %s', 'infoamazonia' ), get_the_date() . '</h1>' );
	elseif (is_month()) :
		printf('<h1 class="title">' . __( 'Monthly Archives: %s', 'infoamazonia' ), get_the_orig_date(_x('F Y', 'monthly archives date format', 'infoamazonia')) . '</h1>');
	elseif (is_year()) :
		printf('<h1 class="title">' . __('Yearly Archives: %s', 'infoamazonia'), get_the_orig_date(_x('Y', 'yearly archives date format', 'infoamazonia')) . '</h1>');
	else :
		echo '<h1 class="title">' . __('Archives', 'twentytwelve') . '</h1>';
	endif;
endif; ?>