<?php
	global $mappress_map;
	$conf = array('postID' => $mappress_map->ID); // default;
	if(is_post_type_archive('map')) {
		$conf['disableMarkers'] = true;
		$conf['disableHash'] = true;
		$conf['disableInteraction'] = true;
	}
	if($conf)
		$conf = json_encode($conf);
?>
<div class="map-container"><div id="map_<?php echo $mappress_map->ID; ?>" class="map"></div></div>
<script type="text/javascript">mappress(<?php echo $conf; ?>);</script>