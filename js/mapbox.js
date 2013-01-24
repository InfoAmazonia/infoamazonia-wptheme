var buildMap;
var mapCallbacks;
var maps = {};

(function($) {

	buildMap = function(mapConf) {

		$('#' + mapConf.containerID).empty();

		var layers = mapConf.layers;
		if(mapConf.server) {
			layers = [];
			$.each(mapConf.layers, function(i, layer) {
				layers.push(mapConf.server + layer + '.json');
			});
		}

		mapbox.load(layers, function(data) {

			var map = mapbox.map(mapConf.containerID);

			$.each(data, function(i, layer) {
				if(!mapConf.server)
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

			if(mapConf.center)
				map.center(mapConf.center);

			if(mapConf.zoom)
				map.zoom(mapConf.zoom);

			if(mapConf.extent)
				map.setExtent(mapConf.extent);

			if(mapConf.panLimits && !mapConf.preview)
				map.setPanLimits(mapConf.panLimits);

			if((mapConf.minZoom || mapConf.maxZoom) && !mapConf.preview)
				map.setZoomRange(mapConf.minZoom, mapConf.maxZoom);

			// store map
			maps[mapConf.containerID] = map;

			if(typeof mapCallbacks === 'function')
				mapCallbacks();

		});
	}

})(jQuery);