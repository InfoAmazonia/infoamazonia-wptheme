<?php if(is_active_sidebar('main-sidebar')) : ?>
	<aside id="main-widgets">
		<div class="container">
			<div class="widgets">
				<?php dynamic_sidebar('main-sidebar'); ?>
			</div>
		</div>
	</aside>
<?php endif; ?>