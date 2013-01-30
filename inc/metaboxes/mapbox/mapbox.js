(function($) {

	var mapConf = {};
	var map_id;

	$(document).ready(function() {
		var post_id = $('input[name=post_ID]').val();

		$('.map-container > .map').attr('id', 'map_' + post_id);
		mapConf.containerID = map_id = 'map_' + post_id;
	});

	var updateMapConf = function() {

		// layers and container id
		mapConf.layers = getLayers();

		// server
		if($('input[name="map_data[server]"]:checked').val() === 'custom') {
			mapConf.server = $('input[name="map_data[custom_server]"]').val();
		}

		// center
		if($('.centerzoom.map-setting input.center-lat').val()) {
			var $centerInputs = $('.centerzoom.map-setting');
			mapConf.center = {
				lat: $centerInputs.find('input.center-lat').val(),
				lon: $centerInputs.find('input.center-lon').val()
			}
		}

		// zoom
		if($('.centerzoom.map-setting input.zoom').val())
			mapConf.zoom = $('.centerzoom.map-setting input.zoom').val();
		// min zoom
		if($('#min-zoom-input').val())
			mapConf.minZoom = parseInt($('#min-zoom-input').val());
		// max zoom
		if($('#max-zoom-input').val())
			mapConf.maxZoom = parseInt($('#max-zoom-input').val());


		// pan limits
		if($('.pan-limits.map-setting input.east').val()) {
			mapConf.panLimits =	$('.pan-limits.map-setting input.north').val() + ',' +
								$('.pan-limits.map-setting input.west').val() + ',' +
								$('.pan-limits.map-setting input.south').val() + ',' +
								$('.pan-limits.map-setting input.east').val();
		}

		// geocode
	 	if($('#mapbox-metabox .enable-geocode').is(':checked'))
	 		mapConf.geocode = true;
	 	else
	 		mapConf.geocode = false;

	 	if($('#mapbox-metabox .toggle-preview-mode').is(':checked'))
	 		mapConf.preview = true;
	 	else
	 		mapConf.preview = false;

		// save mapConf
		storeConf(mapConf);

		return mapConf;
	}

	function storeConf(conf) {
		var storable = $.extend({}, conf);
		delete storable.callbacks;
		delete storable.preview;
		$('input[name=map_conf]').val(JSON.stringify(storable));
	}

	function updateMap() {
		updateMapConf();
		if(typeof mappress.maps[map_id] === 'object')
			mapConf.extent = mappress.maps[map_id].getExtent();

		mappress(mapConf);
	}

	function updateMapData() {
		var extent = mappress.maps[map_id].getExtent();
		var center = mappress.maps[map_id].center();
		var zoom = mappress.maps[map_id].zoom();
		$('.current.map-setting .east').text(extent.east);
		$('.current.map-setting .north').text(extent.north);
		$('.current.map-setting .south').text(extent.south);
		$('.current.map-setting .west').text(extent.west);
		$('.current.map-setting .center').text(center);
		$('.current.map-setting .zoom').text(zoom);
	}

	mapConf.callbacks = function() {
		mappress.maps[map_id].addCallback('drawn', function() {
			updateMapData();
		});
		mappress.maps[map_id].addCallback('zoomed', function() {
			updateMapData();
		});
		mappress.maps[map_id].addCallback('panned', function() {
			updateMapData();
		});
	}

	$(document).ready(function() {

		mappress(updateMapConf());

		/*
		 * Custom server setup
		 */
		var toggleCustomServer = function() {
			var $mapServerInput = $('input[name="map_data[server]"]:checked');
			var $mapCustomServerInput = $('input[name="map_data[custom_server]"]');
			if($mapServerInput.val() === 'mapbox')
				$mapCustomServerInput.attr('disabled', 'disabled');
			else
				$mapCustomServerInput.attr('disabled', false);
		}
		$('input[name="map_data[server]"]').change(function() {
			toggleCustomServer();
		});
		toggleCustomServer();

		/*
		 * Layer management
		 */
		$('#mapbox-metabox .add-layer').click(function() {
			addLayer();
			return false;
		});
		$('#mapbox-metabox .remove-layer').live('click', function() {
			removeLayer($(this).parents('li'));
			return false;
		});

		/*
		 * Map preview button
		 */
		$('#mapbox-metabox .preview-map').click(function() {
			updateMap();
			return false;
		});

		/*
		 * Manage map confs
		 */
		$('#mapbox-metabox .set-map-centerzoom').click(function() {
			updateCenterZoom();
			return false;
		});
		$('#mapbox-metabox .set-map-pan').click(function() {
			updatePanLimits();
			return false;
		});
		$('#mapbox-metabox .set-max-zoom').click(function() {
			updateMaxZoom();
			return false;
		});
		$('#mapbox-metabox .set-min-zoom').click(function() {
			updateMinZoom();
			return false;
		});

		/*
		 * Toggle preview mode
		 */
		 $('#mapbox-metabox .toggle-preview-mode').change(function() {
		 	if($(this).is(':checked'))
		 		mapConf.preview = true;
		 	else
		 		mapConf.preview = false;

		 	updateMap();
		 });

		 $('#mapbox-metabox .enable-geocode').change(function() {
		 	if($(this).is(':checked'))
		 		mapConf.geocode = true;
		 	else
		 		mapConf.geocode = false;

		 	updateMap();
		 });

		function updateCenterZoom() {
			var center = mappress.maps[map_id].center();
			var zoom = mappress.maps[map_id].zoom();
			$('.centerzoom.map-setting span.center').text(center);
			$('.centerzoom.map-setting span.zoom').text(zoom);

			// update inputs
			$('.centerzoom.map-setting input.center-lat').val(center.lat);
			$('.centerzoom.map-setting input.center-lon').val(center.lon);
			$('.centerzoom.map-setting input.zoom').val(zoom);
		}

		function updatePanLimits() {
			var extent = mappress.maps[map_id].getExtent();
			$('.pan-limits.map-setting span.east').text(extent.east);
			$('.pan-limits.map-setting span.north').text(extent.north);
			$('.pan-limits.map-setting span.south').text(extent.south);
			$('.pan-limits.map-setting span.west').text(extent.west);

			// update inputs
			$('.pan-limits.map-setting input.east').val(extent.east);
			$('.pan-limits.map-setting input.north').val(extent.north);
			$('.pan-limits.map-setting input.south').val(extent.south);
			$('.pan-limits.map-setting input.west').val(extent.west);
		}

		function updateMaxZoom() {
			var zoom = mappress.maps[map_id].zoom();
			$('#max-zoom-input').val(zoom);
		}

		function updateMinZoom() {
			var zoom = mappress.maps[map_id].zoom();
			$('#min-zoom-input').val(zoom);
		}

	});

	function addLayer() {
		$('#mapbox-metabox .layers-list').append($('<li><input type="text" name="map_data[layers][]" size="50" /> <a class="remove-layer button" href="#">' + mapbox_metabox_localization.remove_layer + '</a></li>'));
	}

	function removeLayer(layer) {
		layer.remove();
		updateMap();
	}

	function getLayers() {
		var layers = [];
		$('#mapbox-metabox .layers-list li').each(function() {
			layers.push($(this).find('input').val());
		});
		return layers;
	}

})(jQuery);