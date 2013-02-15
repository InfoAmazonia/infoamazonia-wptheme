<?php if(is_active_sidebar('main-sidebar')) : ?>
	<aside id="main-widgets">
		<div class="limiter clearfix">
			<ul class="widgets">
				<?php dynamic_sidebar('main-sidebar'); ?>
			</ul>
		</div>
	</aside>
<?php endif; ?>