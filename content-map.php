<?php $conf = mappress_map_conf(); ?>
<div class="map-container"><div id="map_<?php echo mappress_get_map_id(); ?>" class="map"></div></div>
<script type="text/javascript">mappress(<?php echo $conf; ?>);</script>