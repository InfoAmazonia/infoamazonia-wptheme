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

			/*
			 *
			 */

			mappress.interaction(map);
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

			// store map
			mappress.maps[map_id] = map;

			/*
			 * Widgets
			 */
			var $widgets = $map.parent().find('.map-widgets');
			if(conf.geocode)
				mappress.geocode(map_id);

			if(conf.filteringLayers)
				mappress.filterLayers(map_id, conf.filteringLayers);

			if(typeof conf.callbacks == 'function')
				conf.callbacks();

			// hide widgets on interaction
			map.interaction.on({
				on: function() {
					$widgets.addClass('hide');
				},
				off: function() {
					$widgets.removeClass('hide');
				}
			});

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
	 * Interaction fix
	 */

	mappress.interaction = function(map) {
			
		var interaction = wax.mm.interaction().map(map);

		var interactive_layers = [];
		$.each(map.layers, function(i, layer) {
			if(layer._mapboxhosting && layer.tilejson && layer.enabled) {
				interactive_layers.push(layer._id);
			}
		});

		if(interactive_layers.length) {
			var tilejson_url = 'http://api.tiles.mapbox.com/v3/' + interactive_layers.join() + '.jsonp';
			wax.tilejson(tilejson_url, function(tj) {
				interaction
					.tilejson(tj)
					.on(wax.tooltip()
						.animate(true)
						.parent(map.parent)
						.events()).on(wax.location().events());
			});
		}

	}

})(jQuery);