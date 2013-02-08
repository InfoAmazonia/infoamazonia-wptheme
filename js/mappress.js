var mappress = {};

(function($) {

	/*
	 * MAP BUILD
	 * conf:
	 * - containerID
	 * - server
	 * - layers
	 * - filterLayers
	 * - center
	 * - zoom
	 * - extent (MM.Extent)
	 * - panLimits (MM.Extent)
	 * - minZoom
	 * - maxZoom
	 * - geocode (bool)
	 */

	mappress = function(conf) {

		var	map = {};
		var map_id = conf.containerID;

		var layers = mappress.setupLayers(conf.layers);

		mapbox.load(layers, function(data) {

			map = mapbox.map(map_id);

			map.conf = conf;

			map.conf.formattedLayers = layers;

			map.$ = $('#' + map_id);
			map.$.empty().parent().find('.map-widgets').remove();
			map.$.parent().prepend('<div class="map-widgets"></div>');

			map.map_id = map_id;

			/*
			if(data.length >= 2) {
				$.each(data, function(i, layer) {
					if(!conf.server)
						layer.layer._mapboxhosting = true;
					map.addLayer(layer.layer);
					if(layer.markers)
						map.addLayer(layer.markers);
				});
			} */

			map.addLayer(data.layer);

			// overwrite interaction with custom
			map.interaction = mappress.interaction().map(map);

			map.interaction.auto();
			map.ui.zoomer.add();

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
			map.$.widgets = map.$.parent().find('.map-widgets');

			// store map
			mappress.maps[map_id] = map;

			if(conf.geocode)
				mappress.geocode(map_id);

			if(conf.filteringLayers)
				mappress.filterLayers(map_id, conf.filteringLayers);

			if(typeof conf.callbacks === 'function')
				conf.callbacks();

			// fullscreen widgets callback
			map.addCallback('drawn', function(map) {
				if(map.$.hasClass('map-fullscreen-map')) {
					map.$.widgets.addClass('fullscreen');
					// temporary fix scrollTop
					document.body.scrollTop = 0;
				} else {
					map.$.widgets.removeClass('fullscreen');
				}
			});

		});
	};

	mappress.maps = {};

	mappress.setupLayers = function(layers) {

		// separate layers
		var tileLayers = [];
		var mapboxLayers = [];
		var customServerLayers = [];
		
		$.each(layers, function(i, layer) {
			if(layer.indexOf('http') !== -1) {
				tileLayers.push(layer);
			} else {
				mapboxLayers.push(layer);
			}
		});

		/*
		 * Currently only working with mapbox layers
		 */

		mapboxLayers = mapboxLayers.join();
		return mapboxLayers;
	};

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

	    /*
	    interaction.refresh = function() {
	        var map = interaction.map();
	        if (!auto || !map) return interaction;

			var interactive_layers = [];
			if(map.layers.length >= 2) {

				$.each(map.layers, function(i, layer) {
					if(layer._mapboxhosting && layer.tilejson && layer.enabled) {
						interactive_layers.push(layer._id);
					}
				});

				var tilejson_url = 'http://api.tiles.mapbox.com/v3/' + interactive_layers.join() + '.jsonp';
				return wax.tilejson(tilejson_url, function(tj) { return interaction.tilejson(tj); });

			} else {

                var tj = map.layers[0].tilejson && map.layers[0].tilejson();
                if (tj && tj.template) return interaction.tilejson(tj);

			}
	    };
	    */

	    interaction.refresh = function() {
	        var map = interaction.map();
	        if (!auto || !map) return interaction;
	        for (var i = map.layers.length - 1; i >= 0; i --) {
	            if (map.layers[i].enabled) {
	                var tj = map.layers[i].tilejson && map.layers[i].tilejson();
	                if (tj && tj.template) return interaction.tilejson(tj);
	            }
	        }
	        return interaction.tilejson({});
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
						interaction.map().$.widgets.addClass('hide');
					},
					off: function() {
						interaction.map().$.widgets.removeClass('hide');
					}
				});
	        return interaction.refresh();
	    };

	    return interaction;
	}

	/*
	 * Utils
	 */

	mappress.convertMapConf = function(conf) {

		var newConf = {};
		if(conf.server != 'mapbox')
			newConf.server = conf.server;

		newConf.layers = [];
		newConf.filterLayers = [];
		newConf.filterLayers.switch = [];
		newConf.filterLayers.swap = [];

		$.each(conf.layers, function(i, layer) {
			newConf.layers.push(layer.id);
			if(layer.opts) {
				if(layer.opts.filtering == 'switch') {
					var switchLayer = {
						id: layer.id,
						title: layer.title
					};
					if(layer.switch_hidden)
						switchLayer.hidden = true;
					newConf.filterLayers.switch.push(switchLayer);
				}
				if(layer.opts.filtering == 'swap') {
					var swapLayer = {
						id: layer.id,
						title: layer.title
					}
					if(conf.swap_first_layer == layer.id) {
						layer.first = true;
					}
				}
			}
		});

		newConf.center = conf.center;
		newConf.panLimits = conf.pan_limits.north + ',' + conf.pan_limits.west + ',' + conf.pan_limits.south + ',' + conf.pan_limits.east;
		newConf.zoom = parseInt(conf.zoom);
		newConf.minZoom = parseInt(conf.min_zoom);
		newConf.maxZoom = parseInt(conf.max_zoom);

		if(conf.geocode)
			newConf.geocode = true;

		return newConf;
	}

})(jQuery);