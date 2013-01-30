(function($) {

	mappress.switchableLayers = function(map_id, switchables, hiddens) {
		var map = mappress.maps[map_id];

		var list = '';
		_.each(switchables, function(switchable) {
			list += '<li data-layer="' + switchable.layer + '" class="active">' + switchable.title + '</li>';
		});
		var widget = mappress.widget(map_id, '<ul class="switch-layers">' + list + '</ul>');

		hiddens = _.filter(switchables, function(switchable) { return hiddens.indexOf(switchable.layer) != -1; });
		_.each(hiddens, function(hidden) {
			map.disableLayer(hidden.layer);
			widget.find('li[data-layer="' + hidden.layer + '"]').removeClass('active');
		});

		widget.find('li').click(function() {
			mappress.switchableLayers.switch(map_id, $(this).data('layer'), widget);
		});
	}

	mappress.switchableLayers.switch = function(map_id, layer, widget) {
		var map = mappress.maps[map_id];
		map.getLayer(layer).enabled ? map.getLayer(layer).disable() : map.getLayer(layer).enable();
		if(typeof widget != 'undefined') {
			if(map.getLayer(layer).enabled)
				widget.find('li[data-layer="' + layer + '"]').addClass('active');
			else
				widget.find('li[data-layer="' + layer + '"]').removeClass('active');
		}
	}

})(jQuery);