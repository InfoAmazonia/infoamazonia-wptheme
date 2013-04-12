<?php get_header(); ?>

<?php
$default_map = array_shift(get_posts(array('name' => 'deforestation', 'post_type' => 'map')));
?>
<section id="content"><div class="gray-page">
  <div id='ia-widget' class='limiter'>
    <div id='configuration' class='clearfix'>
      <div class='section layer'>
        <div class='inner'>
          <h4>
            Choose a Map
            <a class='tip' href='#'>
              ?
              <div class='popup arrow-left'>
                Choose any map from the list.
              </div>
            </a>
          </h4>
          <div id='maps'>
          	<?php $maps = get_posts(array('post_type' => 'map', 'posts_per_page' => -1)); ?>
          	<select id="map-select" data-placeholder="<?php _e('Select a map', 'infoamazonia'); ?>" class="chzn-select">
				<?php foreach($maps as $map) : ?>
					<option value="<?php echo $map->ID; ?>" <?php if($map->ID === $default_map->ID) echo 'selected'; ?>><?php echo get_the_title($map->ID); ?></option>
				<?php endforeach; ?>
			</select>
          </div>
        </div>
      </div>

      <div class='section'>
        <div class='inner'>
          <h4>
            Select a Story
            <a class='tip' href='#'>
              ?
              <div class='popup arrow-left'>
                Choose a story from a variety of
                different sources.
              </div>
            </a>
          </h4>
          <?php $publishers = get_terms('publisher'); ?>
          <div id='stories'>
          	<select id="stories-select" data-placeholder="<?php _e('Select stories', 'infoamazonia'); ?>" class="chzn-select">
				<option value="latest"><?php _e('Map stories', 'infoamazonia'); ?></option>
				<option value="no-story"><?php _e('No stories', 'infoamazonia'); ?></option>
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
            Width &amp; Height
            <a class='tip' href='#'>
              ?
              <div class='popup arrow-left'>
                Select the width and height
                proportions you would like the
                embed to be.
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
            HTML Output
            <a class='tip' href='#'>
              ?
              <div class='popup arrow-left'>
                Copy and paste this code into
                an HTML page.
              </div>
            </a>
          </h4>
          <textarea id='output'></textarea>
        </div>
      </div>
    </div>

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