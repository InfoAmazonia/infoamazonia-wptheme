(function($) {

	mappress.filterLayers = function(map_id, layers) {

		var map = mappress.maps[map_id];

		console.log(map.conf);

		/*
		 * Swapables
		 */
		if(layers.swap && layers.swap.length >= 2) {
			var swap = layers.swap;
			var list = '';
			_.each(swap, function(layer) {
				var attrs = '';
				if(layer.first)
					attrs = 'class="active"';
				else
					mappress.disableLayer(map, layer.id);
				list += '<li data-layer="' + layer.id + '" ' + attrs + '>' + layer.title + '</li>';
			});
			var swapWidget = mappress.widget(map_id, '<ul class="swap-layers">' + list + '</ul>');

			swapWidget.find('li').click(function() {
				mappress.filterLayers.swap(map_id, $(this).data('layer'), swap, swapWidget);
			});
		}

		/*
		 * Switchables
		 */
		if(layers.switch && layers.switch.length) {
			var switchable = layers.switch;
			var list = '';
			_.each(switchable, function(layer) {
				var attrs = 'class="active"';
				if(layer.hidden) {
					attrs = '';
					map.disableLayer(layer.id);
				}
				list += '<li data-layer="' + layer.id + '" ' + attrs + '>' + layer.title + '</li>';
			});
			var switchWidget = mappress.widget(map_id, '<ul class="switch-layers">' + list + '</ul>');

			switchWidget.find('li').click(function() {
				mappress.filterLayers.switch(map_id, $(this).data('layer'), switchWidget);
			});
		}

		mappress.filterLayers.switch = function(map_id, layer, widget) {
			var map = mappress.maps[map_id];
			map.getLayer(layer).enabled ? map.getLayer(layer).disable() : map.getLayer(layer).enable();
			if(typeof widget != 'undefined') {
				if(map.getLayer(layer).enabled)
					widget.find('li[data-layer="' + layer + '"]').addClass('active');
				else
					widget.find('li[data-layer="' + layer + '"]').removeClass('active');
			}
			map.interaction.refresh();
		};

		mappress.filterLayers.swap = function(map_id, layer, swapLayers, widget) {
			var map = mappress.maps[map_id];
			if(map.getLayer(layer).enabled)
				return;

			_.each(swapLayers, function(swapLayer) {
				if(swapLayer.id == layer) {
					map.getLayer(layer).enable();
					if(typeof widget != 'undefined')
						widget.find('li[data-layer="' + layer + '"]').addClass('active');
				} else {
					if(map.getLayer(swapLayer.id).enable) {
						map.getLayer(swapLayer.id).disable();
						if(typeof widget != 'undefined')
							widget.find('li[data-layer="' + swapLayer.id + '"]').removeClass('active');
					}
				}
			});
			map.interaction.refresh();
		};

		mappress.filterLayers.disableLayer = function(map, layer) {
			var mapLayers = map.conf.layers;
			$.each(mapLayers, function(i, mapLayer) {
				if(mapLayer == layer)
					mapLayers.splice(i, 1);
			});

			var updatedLayers = mappress.setupLayers(mapLayers);

			mapbox.load(updatedLayers, function(data) {
				map.setLayerAt(0, data.layer);
				map.interaction.refresh();
			});
		};

		mappress.filterLayers.enableLayer = function(map, layer) {
			var mapLayers = map.conf.layers;
		};

		mappress.filterLayers.update = function(conf) {
			mappress(conf);
		};

	};

})(jQuery);