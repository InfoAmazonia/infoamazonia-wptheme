<?php

// enqueue mapbox scripts and styles
add_action('admin_footer', 'mappress_scripts');

/* gather metaboxes */

include(TEMPLATEPATH .  '/inc/metaboxes/story/story-meta.php');
include(TEMPLATEPATH .  '/inc/metaboxes/featured/featured.php');
include(TEMPLATEPATH .  '/inc/metaboxes/map-relation/map-relation.php');
include(TEMPLATEPATH .  '/inc/metaboxes/geocode/geocode.php');
include(TEMPLATEPATH .  '/inc/metaboxes/mapbox/mapbox.php');
include(TEMPLATEPATH .  '/inc/metaboxes/mapbox/legend.php');
include(TEMPLATEPATH .  '/inc/metaboxes/mapgroup/mapgroup.php');