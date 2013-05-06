<?php get_header(); ?>

<section id="content"><div class="gray-page">
  <div id='ia-widget' class='limiter'>
	<div id='configuration' class='clearfix'>
	  <div class='section layer'>
		<div class='inner'>
		  <?php if(!isset($_GET['map_id']) && !isset($_GET['layers'])) : ?>
			<h4>
			  <?php _e('Choose a map', 'infoamazonia'); ?>
			  <a class='tip' href='#'>
				?
				<div class='popup arrow-left'>
				  <?php _e('Choose any map from the list', 'infoamazonia'); ?>
				</div>
			  </a>
			</h4>
			<div id='maps'>
			  <?php $maps = get_posts(array('post_type' => 'map', 'posts_per_page' => -1)); ?>
			  <select id="map-select" data-placeholder="<?php _e('Select a map', 'infoamazonia'); ?>" class="chzn-select">
				<?php foreach($maps as $map) : ?>
				  <option value="<?php echo $map->ID; ?>"><?php echo get_the_title($map->ID); ?></option>
				<?php endforeach; ?>
			  </select>
			  <a href="#" class="select-map-layers" style="display:block;margin-top:5px;"><?php _e('Select layers from this map', 'infoamazonia'); ?></a>
			</div>
		  <?php else : ?>
			<?php 
			$map_id = $_GET['map_id'];
			$map = get_post($map_id);
			if($map || isset($_GET['layers'])) : ?>
			  <h4>
			  	<?php if(!isset($_GET['layers'])) : ?>
					<?php echo __('Select layers from ', 'infoamazonia') . get_the_title($map_id); ?>
				<?php else : ?>
					<?php _e('Select layers', 'infoamazonia'); ?>
				<?php endif; ?>
				<a class='tip' href='#'>
				  ?
				  <div class='popup arrow-left'>
					<?php _e('Choose any layers from the list', 'infoamazonia'); ?>
				  </div>
				</a>
			  </h4>
			  <div id='maps'>
				<?php
				if(!isset($_GET['layers'])) {
					$layers = mappress_get_map_layers($map_id);
				} else {
					$layers = explode(',', $_GET['layers']);
				}
				if($layers) : ?>
				  <select id="layers-select" data-placeholder="<?php _e('Select layers', 'infoamazonia'); ?>" data-mapid="<?php echo $map_id; ?>" class="chzn-select" multiple>
					<?php foreach($layers as $layer) : ?>
						<?php
						if(!is_array($layer)) :
							$l = array('id' => $layer, 'title' => $layer);
							$layer = $l;
						endif;
						?>
					  <option value="<?php echo $layer['id']; ?>" selected><?php if($layer['title']) : echo $layer['title']; else : echo $layer['id']; endif; ?></option>
					<?php endforeach; ?>
				  </select>
				<?php endif; ?>
				<a class="clear-layers" href="#" style="display:block;margin-top:5px;"><?php _e('Back to default layer configuration', 'infoamazonia'); ?></a>
			  </div>
			<?php endif; ?>
		  <?php endif; ?>
		</div>
	  </div>

	  <div class='section'>
		<div class='inner'>
		  <h4>
			<?php _e('Select a story', 'infoamazonia'); ?>
			<a class='tip' href='#'>
			  ?
			  <div class='popup arrow-left'>
				<?php _e('Choose a story from a variety of different sources', 'infoamazonia'); ?>
			  </div>
			</a>
		  </h4>
		  <?php $publishers = get_terms('publisher'); ?>
		  <div id='stories'>
			<select id="stories-select" data-placeholder="<?php _e('Select stories', 'infoamazonia'); ?>" class="chzn-select">
			  <?php
			  if(isset($_GET['p'])) :
				$story = get_post($_GET['p']);
				if($story) : ?>
				  <optgroup label="<?php _e('Selected story', 'infoamazonia'); ?>">
					<option value="story&<?php echo $story->ID; ?>" selected><?php echo get_the_title($story->ID); ?></option>
				  </optgroup>
				<?php endif; ?>
			  <?php endif; ?>
			  <optgroup label="<?php _e('General stories', 'infoamazonia'); ?>">
						<option value="latest"><?php if(!isset($_GET['map_id'])) _e('Stories from the map', 'infoamazonia'); else _e('Latest stories', 'infoamazonia'); ?></option>
						<option value="no-story"><?php _e('No stories', 'infoamazonia'); ?></option>
			  </optgroup>
					<optgroup label="<?php _e('By publishers', 'infoamazonia'); ?>">
						<?php foreach($publishers as $publisher) : ?>
							<option value="publisher&<?php echo $publisher->slug; ?>"><?php echo $publisher->name; ?></option>
						<?php endforeach; ?>
					</optgroup>
			</select>
		  </div>
		</div>
	  </div>

	  <div class='section size'>
		<div class='inner'>
		  <h4>
			<?php _e('Width & Height', 'infoamazonia'); ?>
			<a class='tip' href='#'>
			  ?
			  <div class='popup arrow-left'>
				<?php _e('Select the width and height proportions you would like to embed to be.', 'infoamazonia'); ?>
			  </div>
			</a>
		  </h4>
		  <ul id='sizes' class='sizes clearfix'>
			<li><a href='#' data-size='small' data-width='480' data-height='300'>Small</a></li>
			<li><a href='#' data-size='medium' data-width='600' data-height='400'>Medium</a></li>
			<li><a href='#' data-size='large' data-width='960' data-height='480' class='active'>Large</a></li>
		  </ul>
		</div>
	  </div>

	  <div class='section output'>
		<div class='inner'>
		  <h4>
			<div class='popup arrow-right'>
			</div>
			<?php _e('HTML Output', 'infoamazonia'); ?>
			<a class='tip' href='#'>
			  ?
			  <div class='popup arrow-left'>
				<?php _e('Copy and paste this code into an HTML page', 'infoamazonia'); ?>
			  </div>
			</a>
		  </h4>
		  <textarea id='output'></textarea>
		</div>
	  </div>
	</div>

	<?php /*
	<div class="section centerzoom">
		<div class="inner">
		  <h4 style="margin-top:10px;">
			<div class='popup arrow-right'>
			</div>
			<?php _e('Use map center & zoom', 'infoamazonia'); ?>
			<a class='tip' href='#'>
			  ?
			  <div class='popup arrow-left'>
				<?php _e('Get the current center & zoom from the preview below and use as default for the embed', 'infoamazonia'); ?>
			  </div>
			</a>
		  </h4>
			<div class="centerzoom">
				<p class="latitude">Latitude: <span class="val"><?php _e('default', 'infoamazonia'); ?></span></p>
				<p class="longitude">Longitude: <span class="val"><?php _e('default', 'infoamazonia'); ?></span></p>
				<p class="zoom">Zoom: <span class="val"><?php _e('default', 'infoamazonia'); ?></span></p>
				<a class="grab-centerzoom button" href="#"><?php _e('Grab center & zoom', 'infoamazonia'); ?></a>
				<a class="default-centerzoom button" href="#"><?php _e('Use default', 'infoamazonia'); ?></a>
			</div>
		</div>
	</div>
	*/ ?>

	<div class='content' id='widget-content'>
		<!-- iframe goes here -->
	</div>

  </div>
</div></div>

<script type="text/javascript">
	jQuery(document).ready(function($) { 
		widget.controls();
	});
</script>

<?php get_footer(); ?>