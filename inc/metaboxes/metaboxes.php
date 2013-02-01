<?php

// enqueue mapbox scripts and styles
add_action('admin_footer', 'mappress_scripts');

/* gather metaboxes */

include(TEMPLATEPATH .  '/inc/metaboxes/geocode/geocode.php');
include(TEMPLATEPATH .  '/inc/metaboxes/mapbox/mapbox.php');
include(TEMPLATEPATH .  '/inc/metaboxes/mapgroup/mapgroup.php');