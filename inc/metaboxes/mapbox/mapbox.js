(function($) {

	var mapConf = {};

	var updateMapConf = function() {

		// layers and container id
		mapConf.layers = getLayers();
		mapConf.containerID = 'map_preview';

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
			mapConf.panLimits = new MM.Extent(
				parseFloat($('.pan-limits.map-setting input.north').val()),
				parseFloat($('.pan-limits.map-setting input.west').val()),
				parseFloat($('.pan-limits.map-setting input.south').val()),
				parseFloat($('.pan-limits.map-setting input.east').val())
			)
		}

		mapConf.preview = true;

		return mapConf;
	}

	function updateMap() {

		if(typeof maps.map_preview === 'object')
			mapConf.extent = maps.map_preview.getExtent();

		buildMap(mapConf);
	}

	function updateMapData() {
		var extent = maps.map_preview.getExtent();
		var center = maps.map_preview.center();
		var zoom = maps.map_preview.zoom();
		$('.current.map-setting .east').text(extent.east);
		$('.current.map-setting .north').text(extent.north);
		$('.current.map-setting .south').text(extent.south);
		$('.current.map-setting .west').text(extent.west);
		$('.current.map-setting .center').text(center);
		$('.current.map-setting .zoom').text(zoom);
	}

	mapCallbacks = function() {

		maps.map_preview.addCallback('drawn', function() {
			updateMapData();
		});
		maps.map_preview.addCallback('zoomed', function() {
			updateMapData();
		});
		maps.map_preview.addCallback('panned', function() {
			updateMapData();
		});

	}

	$(document).ready(function() {

		buildMap(updateMapConf());

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
			updateMapConf();
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
		 		togglePreview(true);
		 	else
		 		togglePreview(false);
		 });

		function updateCenterZoom() {
			var center = maps.map_preview.center();
			var zoom = maps.map_preview.zoom();
			$('.centerzoom.map-setting span.center').text(center);
			$('.centerzoom.map-setting span.zoom').text(zoom);

			// update inputs
			$('.centerzoom.map-setting input.center-lat').val(center.lat);
			$('.centerzoom.map-setting input.center-lon').val(center.lon);
			$('.centerzoom.map-setting input.zoom').val(zoom);
		}

		function updatePanLimits() {
			var extent = maps.map_preview.getExtent();
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
			var zoom = maps.map_preview.zoom();
			$('#max-zoom-input').val(zoom);
		}

		function updateMinZoom() {
			var zoom = maps.map_preview.zoom();
			$('#min-zoom-input').val(zoom);
		}

		function togglePreview(preview) {
			updateMapConf();
			mapConf.preview = preview;
			updateMap();
		}

	});

	function addLayer() {
		$('#mapbox-metabox .layers-list').append($('<li><input type="text" name="map_data[layers][]" size="50" /> <a class="remove-layer button" href="#">' + mapbox_metabox_localization.remove_layer + '</a></li>'));
	}

	function removeLayer(layer) {
		layer.remove();
		updateMapConf();
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