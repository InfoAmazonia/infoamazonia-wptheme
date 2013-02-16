<?php
	$mapConf = false; // default;
	if(is_post_type_archive('map')) {
		$mapConf = array(
			'disableMarkers' => true,
			'disableHash' => true
		);
	}
	if($mapConf)
		$mapConf = json_encode($mapConf);
?>
<div class="map-container"><div id="map_<?php echo $post->ID; ?>" class="map"></div></div>
<script type="text/javascript">mappress(<?php echo $post->ID; ?><?php if($mapConf) echo ', ' . $mapConf; ?>);</script>