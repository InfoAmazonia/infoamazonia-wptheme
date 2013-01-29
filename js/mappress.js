var mappress = {};
mappress.maps = {};

(function($) {

	mappress.build = function(conf) {
		
		var $map = $('#' + conf.containerID);

		$map.empty().parent().find('.map-widgets').remove();
		$map.parent().prepend('<div class="map-widgets"></div>');

		var layers = conf.layers;
		if(conf.server) {
			layers = [];
			$.each(conf.layers, function(i, layer) {
				layers.push(conf.server + layer + '.json');
			});
		}

		mapbox.load(layers, function(data) {

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

			if(conf.extent)
				map.setExtent(conf.extent);

			if(conf.panLimits) {
				map.panLimits = conf.panLimits;
				if(!conf.preview)
					map.setPanLimits(conf.panLimits);
			}

			if((conf.minZoom || conf.maxZoom) && !conf.preview)
				map.setZoomRange(conf.minZoom, conf.maxZoom);

			if(conf.geocode)
				mappress.geocode.activate(conf.containerID);

			// store map
			mappress.maps[conf.containerID] = map;

			if(typeof conf.callbacks === 'function')
				conf.callbacks();

		});

		/*
		 * Map Widgets
		 */

		mappress.widget = {};
		mappress.widgets = {};

		mappress.widget.add = function(map_id, widget_id, content) {
			if(typeof mappress.widgets[map_id] != 'object')
				mappress.widgets[map_id] = {};
			
			mappress.widgets[map_id][widget_id] = $(content);

			var $map = $('#' + map_id);
			$map.parent().find('.map-widgets').append(mappress.widgets[map_id][widget_id]);

			return mappress.widgets[map_id][widget_id];
		}

		mappress.widget.remove = function(map_id, widget_id) {
			mappress.widgets[map_id][widget_id].remove();
			delete mappress.widgets[map_id][widget_id];
		}
	}

})(jQuery);