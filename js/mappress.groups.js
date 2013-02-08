var groups = {};

(function($) {

	mappress.group = function(groupID) {

		var group = {};

		$.getJSON(mappress_groups.ajaxurl, {
			action: 'mapgroup_data',
			group_id: groupID
		}, function(data) {
			mappress.group.build(data);
		});

		mappress.group.build = function(data) {

			group.$ = $('#mapgroup-' + groupID);

			// store maps data
			group.mapsData = data.maps;

			// nodes
			group.$.nav = group.$.find('.map-nav');
			group.$.map = group.$.find('.map');

			group.id = group.$.map.attr('id');

			// prepare first map and group conf
			var firstMapID = group.$.nav.find('li:first-child a').data('map');
			group.conf = mappress.convertMapConf(group.mapsData[firstMapID]);

			// set mappress conf containerID to group id
			group.conf.containerID = group.id;

			// store current map id
			group.currentMapID = firstMapID;

			// build group
			mappress(group.conf);

			// bind nav events
			group.$.nav.find('li a').click(function() {

				var mapID = $(this).data('map');

				if($(this).hasClass('active'))
					return;

				group.$.nav.find('li a').removeClass('active');
				$(this).addClass('active');

				// update layers
				mappress.group.update(mapID);

				return false;
			});

		}

		mappress.group.update = function(mapID) {

			if(!group.map)
				group.map = mappress.maps[group.id];

			// prepare new layers
			var conf = mappress.convertMapConf(group.mapsData[mapID]);
			var layers = mappress.setupLayers(conf.layers);
			mapbox.load(layers, function(data) {

				group.map.setLayerAt(0, data.layer);
				group.map.interaction.refresh();
				
			});

			// update current map id
			group.currentMapID = mapID;
		}

		groups[group.id] = group;
	}

})(jQuery);