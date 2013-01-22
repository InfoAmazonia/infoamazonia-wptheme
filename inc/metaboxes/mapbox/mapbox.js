(function($) {

	$(document).ready(function() {

		$('#mapbox-metabox .add-layer').click(function() {
			addLayer();
			return false;
		});

		$('#mapbox-metabox .remove-layer').live('click', function() {
			removeLayer($(this).parents('li'));
			return false;
		});

		var center = false;
		if($('.centerzoom.map-setting input.center-lat').val()) {
			var $centerInputs = $('.centerzoom.map-setting');
			center = {
				lat: $centerInputs.find('input.center-lat').val(),
				lon: $centerInputs.find('input.center-lon').val()
			}
		}

		var zoom = false;
		if($('.centerzoom.map-setting input.zoom').val()) {
			zoom = $('.centerzoom.map-setting input.zoom').val();
		}

		buildMap('map_preview', getLayers(), false, center, zoom);
		$('#mapbox-metabox .preview-map').click(function() {
			updateMap();
			return false;
		});

		$('#mapbox-metabox .set-map-centerzoom').click(function() {
			updateCenterZoom();
			return false;
		});

		$('#mapbox-metabox .set-map-pan').click(function() {
			updatePanLimits();
			return false;
		});

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

	});

	function updateMap() {
		var extent;
		if(typeof maps.map_preview === 'object')
			extent = maps.map_preview.getExtent();
		else
			extent = false;
		buildMap('map_preview', getLayers(), extent);
		console.log(extent);
	}

	function addLayer() {
		$('#mapbox-metabox .layers-list').append($('<li><input type="text" name="map_layers[]" size="50" /> <a class="remove-layer button" href="#">' + mapbox_metabox_localization.remove_layer + '</a></li>'));
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