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

		var map_id = conf.containerID;

		var layers = conf.layers;
		if(conf.server) {
			layers = [];
			$.each(conf.layers, function(i, layer) {
				layers.push(conf.server + layer + '.json');
			});
		}

		mapbox.load(layers, function(data) {
		
			var $map = $('#' + map_id);
			$map.empty().parent().find('.map-widgets').remove();
			$map.parent().prepend('<div class="map-widgets"></div>');

			var map = mapbox.map(map_id);

			map.id = map_id;

			$.each(data, function(i, layer) {
				if(!conf.server)
					layer.layer._mapboxhosting = true;
				map.addLayer(layer.layer);
				if(layer.markers)
					map.addLayer(layer.markers);
			});

			// overwrite interaction with custom
			map.interaction = mappress.interaction().map(map);

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

			/*
			 * Widgets
			 */
			var $widgets = $map.parent().find('.map-widgets');
			map.widgets = $widgets;

			// store map
			mappress.maps[map_id] = map;

			if(conf.geocode)
				mappress.geocode(map_id);

			if(conf.filteringLayers)
				mappress.filterLayers(map_id, conf.filteringLayers);

			if(typeof conf.callbacks == 'function')
				conf.callbacks();

			// fullscreen widgets callback
			map.addCallback('drawn', function(map) {
				if($map.hasClass('map-fullscreen-map')) {
					$widgets.addClass('fullscreen');
					// temporary fix scrollTop
					document.body.scrollTop = 0;
				} else {
					$widgets.removeClass('fullscreen');
				}
			});

		});
	};

	mappress.maps = {};

	/*
	 * Map widgets
	 */

	mappress.widget = function(map_id, content) {
		var $map = $('#' + map_id);
		var $widgets = $map.parent().find('.map-widgets');
		// add widget
		var widget = $('<div class="map-widget"></div>').append($(content));
		$widgets.append(widget);
		return widget;
	};

	/*
	 * Custom interaction
	 */

	mappress.interaction = function() {

	    var interaction = wax.mm.interaction(),
	        auto = false;

	    interaction.refresh = function() {
	        var map = interaction.map();
	        if (!auto || !map) return interaction;

			var interactive_layers = [];
			$.each(map.layers, function(i, layer) {
				if(layer._mapboxhosting && layer.tilejson && layer.enabled) {
					interactive_layers.push(layer._id);
				}
			});
			var tilejson_url = 'http://api.tiles.mapbox.com/v3/' + interactive_layers.join() + '.jsonp';
			return wax.tilejson(tilejson_url, function(tj) { return interaction.tilejson(tj); });
	    };

	    interaction.auto = function() {
	        auto = true;
	        interaction
		        .on(wax.tooltip()
		            .animate(true)
		            .parent(interaction.map().parent)
		            .events())
		        .on(wax.location().events())
				.on({
					on: function() {
						interaction.map().widgets.addClass('hide');
					},
					off: function() {
						interaction.map().widgets.removeClass('hide');
					}
				});
	        return interaction.refresh();
	    };

	    return interaction;
	}

})(jQuery);