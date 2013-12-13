<?php if(is_tax('publisher')) : 
	$term = get_term_by('slug', get_query_var('publisher'), 'publisher');
	$url = __(get_tax_meta($term->term_id,'publisher_url'));
	?>
	<div class="container">
		<div class="twelve columns">
			<div class="publisher-desc">
				<p class="term-title"><?php single_term_title(); ?></p>
				<?php _e(term_description($term->term_id, 'publisher')); ?>
				<?php if($url) echo '<p><a href="' . $url . '" target="_blank" rel="external">' . __('Visit', 'infoamazonia') . ' ' . $url . '</a></p>'; ?>
			</div>
		</div>
	</div>
<?php endif; ?>