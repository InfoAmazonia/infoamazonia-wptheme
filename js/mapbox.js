var buildMap;
var mapCallbacks;
var maps = {};

(function($) {

	buildMap = function(containerID, layers, extent, center, zoom) {
		$('#' + containerID).empty();
		mapbox.load(layers, function(data) {
			var map = mapbox.map(containerID);

			map.ui.zoomer.add();

			$.each(data, function(i, layer) {
				map.addLayer(layer.layer);
			});
			map.zoom(2).center(data[0].center);
			map.interaction.auto();

			if(center)
				map.center(center);
			else
				map.center(data[0].center);

			if(zoom)
				map.zoom(zoom);
			else
				map.zoom(2);

			if(extent)
				map.setExtent(extent);

			// store map
			maps[containerID] = map;

			if(typeof mapCallbacks === 'function')
				mapCallbacks();
		});
	}

})(jQuery);