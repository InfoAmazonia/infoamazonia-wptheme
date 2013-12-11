=== Advanced Custom Fields: Location Field ===
Contributors: julienbechade, Omicron7, elliotcondon
Tags: admin, advanced, custom, field, custom field, location, address, coordinates, google, map, googlemap
Requires at least: 3.4
Tested up to: 3.3.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a Google Map Location field to the Advanced Custom Fields plugin for both versions 3 & 4. This field allows you to find addresses and coordinates of a desired location.

== Description ==

This is an add-on for the [Advanced Custom Fields](http://wordpress.org/extend/plugins/advanced-custom-fields/)
WordPress plugin and will not provide any functionality to WordPress unless Advanced Custom Fields is installed
and activated.

**This plugin has been written to work for both versions 3 & 4 of ACF.**

The Location field provides:

* a search field where you can type in some coordinates or an address and hit `Enter`. 
* a Google map which you can click at the desired location.

In both cases, Google will find the location and return the coordinates and the complete address, if you want it complete. A marker will be added at the desired location.

= Source Repository on GitHub =
https://github.com/julienbechade/acf-location-field

= Bugs, Questions or Suggestions =
https://github.com/julienbechade/acf-location-field/issues

= Usage =

Make sure you read the [Advanced Custom Fields](http://www.advancedcustomfields.com/docs/getting-started/)'s documentation first.

**Back-end**

The Location field comes with 3 options:

1. The map address let you choose the value(s) to return on the front-end:
	* Coordinates & address
	* Coordinates
2. The map center let you set the coordinates used to center the initial blank map.
2. The map zoom.

**Front-end**

Retrieving the value(s) on the front-end differs according to the Map address options.

* Coordinates & address
` $location = get_field('location'); echo $location['address']; echo $location['coordinates']; `
* Coordinates 
` the_field('location'); `
*Google maps V3 

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
    var map;
    var myLatLang = new google.maps.LatLng( <?php  $location = get_field('location'); echo $location['coordinates']; ?>);
    function initialize() {
        var mapOptions = {
            zoom: 8,
            center: myLatLang,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);
        var marker = new google.maps.Marker({
            position: myLatLang,
            map: map,
            title:"Hello World!"
        });
    };
    google.maps.event.addDomListener(window, 'load', initialize);
    $('.bxslider').bxSlider({
        minSlides: 5,
        maxSlides: 5,
        slideWidth: 192,
        slideMargin: 0,
        adaptiveHeight: true
    });
</script>
<div id="map-canvas"></div>

== Installation ==

This software can be treated as both a WP plugin and a theme include.

= Plugin =
1. Copy the 'acf-location' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

= Include =
1. Copy the 'acf-location' folder into your theme folder (can use sub folders)
   * You can place the folder anywhere inside the 'wp-content' directory
2. Edit your functions.php file and add the following code to include the field:

`
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
	include_once('acf-location/acf-location.php');
}
`

3. Make sure the path is correct to include the acf-location.php file


== Screenshots ==

1. Location field and its options
2. Location field on an edit-post page
3. Type in a partial address or some coordinates
4. Choose to get the complete address


== Changelog ==

= 0.0.1 =
* Initial Release.
