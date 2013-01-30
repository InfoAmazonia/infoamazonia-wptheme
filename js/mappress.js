var mappress;

(function($) {

	/*
	 * MAP BUILD
	 * conf:
	 * - containerID
	 * - server
	 * - layers
	 * - center
	 * - zoom
	 * - extent (MM.Extent)
	 * - panLimits (MM.Extent)
	 * - minZoom
	 * - maxZoom
	 * - geocode (bool)
	 */

	mappress = function(conf) {

		var layers = conf.layers;
		if(conf.server) {
			layers = [];
			$.each(conf.layers, function(i, layer) {
				layers.push(conf.server + layer + '.json');
			});
		}

		mapbox.load(layers, function(data) {
		
			var $map = $('#' + conf.containerID);
			$map.empty().parent().find('.map-widgets').remove();
			$map.parent().prepend('<div class="map-widgets"></div>');

			var map = mapbox.map(conf.containerID);

			map.id = conf.containerID;

			$.each(data, function(i, layer) {
				if(!conf.server)
					layer.layer._mapboxhosting = true;
				map.addLayer(layer.layer);
				if(layer.markers)
					map.addLayer(layer.markers);
			});
			map.interaction.auto();
			map.ui.zoomer.add();
			map.ui.legend.add();
			map.ui.fullscreen.add();
			map.center(data[0].center).zoom(2);

			if(conf.center)
				map.center(conf.center);

			if(conf.zoom)
				map.zoom(conf.zoom);

			if(conf.extent) {
				if(typeof conf.extent === 'string')
					conf.extent = new MM.Extent.fromString(conf.extent);
				else if(typeof conf.extent === 'array')
					conf.extent = new MM.Extent.fromArray(conf.extent);

				if(conf.extent instanceof MM.Extent)
					map.setExtent(conf.extent);
			}

			if(conf.panLimits) {
				if(typeof conf.panLimits === 'string')
					conf.panLimits = new MM.Extent.fromString(conf.panLimits);
				else if(typeof conf.panLimits === 'array')
					conf.panLimits = new MM.Extent.fromArray(conf.panLimits);

				if(conf.panLimits instanceof MM.Extent) {
					map.panLimits = conf.panLimits;
					if(!conf.preview)
						map.setPanLimits(conf.panLimits);
				}
			}

			if((conf.minZoom || conf.maxZoom) && !conf.preview)
				map.setZoomRange(conf.minZoom, conf.maxZoom);

			if(conf.geocode)
				mappress.geocode(conf.containerID);

			// store map
			mappress.maps[conf.containerID] = map;

			if(typeof conf.callbacks == 'function')
				conf.callbacks();

		});
	};

	mappress.maps = {};

	/*
	 * Map widgets
	 */

	mappress.widget = function(map_id, content) {
		var widget = $(content);
		$('#' + map_id).parent().find('.map-widgets').append(widget);
		return widget;
	};

})(jQuery);