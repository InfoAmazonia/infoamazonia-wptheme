<?php $conf = jeo_map_conf(); ?>
<div class="map-container"><div id="map_<?php echo jeo_get_map_id(); ?>" class="map"></div></div>
<script type="text/javascript">jeo(<?php echo $conf; ?>);</script>