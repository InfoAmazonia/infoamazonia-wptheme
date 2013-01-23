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
				layers.push(mapbox.MAPBOX_URL + layer + '.json');
			});
		}

		mapbox.load(layers, function(data) {

			var map = mapbox.map(mapConf.containerID);

			$.each(data, function(i, layer) {
				if(!mapConf.server)
					layer.layer._mapboxhosting = true;
				map.addLayer(layer.layer);
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

			// store map
			maps[mapConf.containerID] = map;

			if(typeof mapCallbacks === 'function')
				mapCallbacks();

		});
	}

})(jQuery);