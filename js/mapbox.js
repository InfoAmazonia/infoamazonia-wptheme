var buildMap;
var mapCallbacks;
var maps = {};

(function($) {

	buildMap = function(containerID, layers, extent, center, zoom) {

		$('#' + containerID).empty();

		mapbox.load(layers, function(data) {

			var map = mapbox.map(containerID);

			$.each(data, function(i, layer) {
				layer.layer._mapboxhosting = true;
				map.addLayer(layer.layer);
			});
			map.interaction.auto();
			map.ui.zoomer.add();
			map.center(data[0].center).zoom(2);

			if(center)
				map.center(center);

			if(zoom)
				map.zoom(zoom);

			if(extent)
				map.setExtent(extent);

			// store map
			maps[containerID] = map;

			if(typeof mapCallbacks === 'function')
				mapCallbacks();

		});
	}

})(jQuery);