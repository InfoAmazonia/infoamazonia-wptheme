<?php
global $mappress_map, $mappress_mapgroup_id;
mappress_setup_mapgroupdata($mappress_map);
$data = get_post_meta($mappress_mapgroup_id, 'mapgroup_data', true);
$main_maps = $more_maps = array();
// separate main maps from "more" maps
foreach($data['maps'] as $map) {
	if(!isset($map['more']))
		$main_maps[] = $map;
	else
		$more_maps[] = $map;
}
?>
<div class="mapgroup-container">
	<div id="mapgroup-<?php echo $mappress_mapgroup_id; ?>" class="mapgroup">
		<ul class="map-nav">
			<?php
			$i = 0;
			foreach($main_maps as $map) :
				$post = get_post($map['id']);
				setup_postdata($post);
				?>
				<li><a href="<?php the_permalink(); ?>" data-map="map_<?php the_ID(); ?>" <?php if($i == 0) echo 'class="active"'; ?>><?php the_title(); ?></a></li>
				<?php
				mappress_reset_mapdata();
				$i++;
			endforeach; ?>
			<?php if($more_maps) : ?>
				<li class="more-tab">
					<a href="#" class="toggle-more"><?php _e('More...', 'infoamazonia'); ?></a>
					<ul class="more-maps-list">
						<?php foreach($more_maps as $map) :
							$post = get_post($map['id']);
							setup_postdata($post);
							?>
							<li class="more-item"><a href="<?php the_permalink(); ?>" data-map="map_<?php the_ID(); ?>" <?php if($i == 0) echo 'class="active"'; ?>><?php the_title(); ?></a></li>
							<?php
							mappress_reset_mapdata();
						endforeach; ?>
						<li><a href="<?php echo qtrans_convertURL(get_post_type_archive_link('map')); ?>"><?php _e('View all maps', 'infoamazonia'); ?></a></li>
					</ul>
				</li>
			<?php endif; ?>
		</ul>
		<div class="map-container">
			<div id="mapgroup_<?php echo $mappress_mapgroup_id; ?>_map" class="map">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var group = mappress.group(<?php echo $mappress_mapgroup_id; ?>);
</script>