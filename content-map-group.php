<?php
$data = get_post_meta($post->ID, 'mapgroup_data', true);
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
	<div id="mapgroup-<?php echo $post->ID; ?>" class="mapgroup">
		<ul class="map-nav">
			<?php
			$i = 0;
			foreach($main_maps as $map) { ?>
				<li><a href="#" data-map="map_<?php echo $map['id']; ?>" <?php if($i == 0) echo 'class="active"'; ?>><?php echo $map['title']; ?></a></li>
			<?php
			$i++;
			} ?>
		</ul>
		<div class="map-sidebar">
			<div class="sidebar-inner"></div>
		</div>
		<div class="map-container">
			<div id="mapgroup_<?php echo $post->ID; ?>_map" class="map">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var group = mappress.group(<?php echo $post->ID; ?>);
</script>