(function($) {

	mappress.group = function(groupID) {

		var $group;

		$(document).ready(function() {

			$group = $('#mapgroup-' + groupID);

			$.getJSON(mappress_groups.ajaxurl, {
				action: 'mapgroup_data',
				group_id: groupID
			}, function(data) {
				mappress.group.build($group, data);
			});

		});

	}

	mappress.group.build = function($group, data) {

		var $nav = $group.find('.map-nav');
		var $map = $group.find('.map');
		var mapID = $map.attr('id');

		// prepare first map
		var firstMapID = $nav.find('li:first-child a').data('map');
		var firstMap = data.maps[firstMapID];
		var mapConf = mappress.convertMapConf(firstMap);
		mapConf.containerID = mapID;

		var map = mappress(mapConf);

		// bind nav events
		$nav.find('li a').click(function() {

			var mapID = $(this).data('map');

			if($(this).hasClass('active'))
				return;

			$nav.find('li a').removeClass('active');
			$(this).addClass('active');

			// get map data
			var mapData = mappress.convertMapConf(data.maps[mapID]);

			// update layers
			mappress.group.update(mapID, mapData);

			return false;
		});

	}

	mappress.group.update = function(mapID, conf) {

	}

})(jQuery);