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

		var map_id = conf.containerID;

		mappress.maps[map_id] = mapbox.map(map_id);

		var map = mappress.maps[map_id];

		// store jquery node
		map.$ = $('#' + map_id);

		mappress.setupHash();

		/*
		 * Widgets (reset and add)
		 */
		map.$.empty().parent().find('.map-widgets').remove();
		map.$.parent().prepend('<div class="map-widgets"></div>');

		map.$.widgets = map.$.parent().find('.map-widgets');

		if(typeof conf.callbacks === 'function')
			conf.callbacks();

		// fullscreen widgets callback
		map.addCallback('drawn', function(map) {
			if(map.$.hasClass('map-fullscreen-map')) {
				map.$.parents('.content-map').addClass('fullscreen');
				map.$.widgets.addClass('fullscreen');
				// store hash
				fragment.set({full: true});
				// temporary fix scrollTop
				document.body.scrollTop = 0;
				map.dimensions = new MM.Point(map.parent.offsetWidth, map.parent.offsetHeight);
			} else {
				// remove hash
				fragment.rm('full');
				map.$.parents('.content-map').removeClass('fullscreen');
				map.$.widgets.removeClass('fullscreen');
			}
		});

		map.$.parents('.content-map').resize(function() {
			map.dimensions = new MM.Point(map.parent.offsetWidth, map.parent.offsetHeight);
			map.draw();
		});

        // Enable zoom-level dependent design.
        map.$.addClass('zoom-' + map.getZoom());
        map.addCallback('drawn', _.throttle(function(map) {
        	if(!map.ease.running()) {
        		var classes = map.$.attr('class');
        		classes = classes.split(' ');
        		$.each(classes, function(i, cl) {
        			if(cl.indexOf('zoom') === 0)
			            map.$.removeClass(cl);
        		});
	            map.$.addClass('zoom-' + parseInt(map.getZoom()));
	        }
        }, 100));

		// store conf
		map.conf = conf;
		map.conf.formattedLayers = layers;

		// store map id
		map.map_id = map_id;

		// layers
		var layers = mappress.setupLayers(conf.layers);
		map.addLayer(mapbox.layer().id(layers, function() {

			map.interaction.auto();

			if(conf.geocode)
				mappress.geocode(map_id);

			if(conf.filteringLayers)
				mappress.filterLayers(map_id, conf.filteringLayers);

		}));

		mappress.markers(map);
		
		/*
		 * CONFS
		 */
		map.ui.zoomer.add();
		map.ui.fullscreen.add();

		if(conf.legend)
			map.ui.legend.add().content(conf.legend);

		if(conf.legend_full)
			mappress.enableDetails(map, conf.legend, conf.legend_full);

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

		var center = conf.center;
		var zoom = conf.zoom;

		// setup hash
		if(typeof mappress.fragment === 'function') {
			var fragment = mappress.fragment();
			var loc = fragment.get('loc');
			if(loc) {
				loc = loc.split(',');
				if(loc.length = 3) {
					center = {
						lat: parseFloat(loc[0]),
						lon: parseFloat(loc[1])
					};
					zoom = parseInt(loc[2]);
				}
			}
		}

		map.centerzoom(center, zoom, true);

		return map;

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
	 * Legend page (map details)
	 */
	mappress.enableDetails = function(map, legend, full) {
		map.ui.legend.add().content(legend + '<span class="map-details-link">' + mappress_localization.more_label + '</span>');

		var isMapGroup = map.$.parents('.content-map').length;
		var $detailsContainer = map.$.parents('.map-container');
		if(isMapGroup)
			$detailsContainer = map.$.parents('.content-map');

		if(!$detailsContainer.hasClass('clearfix'))
			$detailsContainer.addClass('clearfix');

		map.$.find('.map-details-link').unbind().click(function() {

			/*
			$.get(mappress_localization.ajaxurl,
			{
				action: 'map_details',
				page_id: page_id
			},
			function(data) {
				$detailsContainer.append($('<div class="map-details-page"><div class="inner"><a href="#" class="close">×</a>' + data + '</div></div>'));
				$detailsContainer.find('.map-details-page .close, .map-nav a').click(function() {
					$detailsContainer.find('.map-details-page').remove();
					return false;
				});
			});
			*/

			$detailsContainer.append($('<div class="map-details-page"><div class="inner"><a href="#" class="close">×</a>' + full + '</div></div>'));
			$detailsContainer.find('.map-details-page .close, .map-nav a').click(function() {
				$detailsContainer.find('.map-details-page').remove();
				return false;
			});

		});
	}

	/*
	 * Custom fullscreen
	 */
	mappress.fullscreen = function(map) {

		if(map.$.parents('.content-map').length)
			var container = map.$.parents('.content-map');
		else
			var container = map.$.parents('.map-container');

		map.$.find('.map-fullscreen').click(function() {

			if(container.hasClass('fullsreen-map'))
				container.removeClass('fullscreen-map');
			else
				container.addClass('fullscreen-map');

			return false;

		});
	}

	/*
	 * Utils
	 */

	mappress.convertMapConf = function(conf) {

		var newConf = {};
		if(conf.server != 'mapbox')
			newConf.server = conf.server;

		newConf.layers = [];
		newConf.filteringLayers = [];
		newConf.filteringLayers.switch = [];
		newConf.filteringLayers.swap = [];

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
					newConf.filteringLayers.switch.push(switchLayer);
				}
				if(layer.opts.filtering == 'swap') {
					var swapLayer = {
						id: layer.id,
						title: layer.title
					};
					if(conf.swap_first_layer == layer.id)
						swapLayer.first = true;
					newConf.filteringLayers.swap.push(swapLayer);
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

		if(conf.legend)
			newConf.legend = conf.legend;

		if(conf.legend_full)
			newConf.legend_full = conf.legend_full;

		return newConf;
	}

})(jQuery);