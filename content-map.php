<div class="map-container"><div id="map_<?php echo $post->ID; ?>" class="map"></div></div>
<script type="text/javascript">mappress(<?php echo get_post_meta($post->ID, 'map_conf', true); ?>);</script>