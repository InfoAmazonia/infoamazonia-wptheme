mappress.geocode = {};

(function($) {

	mappress.geocode.activate = function(map_id) {
		var $form = $('<form id="' + map_id + '_search" class="map-search"><input type="text" placeholder="' + mappress_labels.search_placeholder + '" /></form>');
		mappress.addWidget(map_id, $form);

		// bind submit event
		$form.submit(function() {
			mappress.geocode.get(map_id, $form.find('input').val());
			return false;
		});
	}

	mappress.geocode.get = function(map_id, search) {

		if(!map_id)
			return;

		var map = mappress.maps[map_id];

		// clear previous search
		mappress.geocode.clear(map_id);

		if(!search)
			return;

		// nominatim query
		search = search.replace('%20','+');
		var query = {
			q: search,
			polygon_geojson: 1,
			format: 'json'
		}

		// set query viewbox
		if(map.panLimits) {
			var viewbox = map.panLimits.west + ',' + map.panLimits.north + ',' + map.panLimits.east + ',' + map.panLimits.south;
			query.viewbox = viewbox;
			query.bounded = 1;
		}

		$.getJSON('http://nominatim.openstreetmap.org/search.php?json_callback=?', query, function(data) {
				mappress.geocode.draw(map, data);
			}
		);
	}

	mappress.geocode.clear = function(map_id) {
		// clear markers
		var markerLayer = mappress.maps[map_id].removeLayer('search-layer');
		// clear d3
		$searchLayer = $('#' + map_id).find('.search-layer');
		if($searchLayer.length)
			$searchLayer.remove();
	}

	mappress.geocode.draw = function(map, data) {

		/*
		 * Draw markers layer (points and linestrings)
		 */
		var markers = _.filter(data, function(d) { if(d.geojson.type == 'Point' || d.geojson.type == 'LineString') return d; });
		if(markers.length) {
			console.log(markers);
			var markerLayer = mapbox.markers.layer();
			markerLayer.named('search-layer');
			mapbox.markers.interaction(markerLayer);
			map.addLayer(markerLayer);

			_.each(markers, function(marker) {
				markerLayer.add_feature({
					geometry: {
						coordinates: [parseFloat(marker.lon), parseFloat(marker.lat)]
					},
					properties: {
						'marker-color': '#000',
						'marker-symbol': 'marker-stroked',
						title: marker.display_name
					}
				})
			});
		}

		/*
		 * Draw polygons and multipolygons with d3js
		 */
		var polygons = _.filter(data, function(d) { if(d.geojson.type == 'Polygon' || d.geojson.type == 'MultiPolygon') return d; });
		if(polygons.length) {
			var data = {
				"type": "FeatureCollection",
				"features": []
			};
			_.each(polygons, function(polygon) {
				var polygonData = {
					"type": "Feature",
					"id": "34",
					"properties": {
						"name": polygon.display_name
					},
					"geometry": polygon.geojson
				}
				data.features.push(polygonData);
			});
			console.log(data);
			var polygonLayer = d3layer().data(data);
			map.addLayer(polygonLayer);
		}

	}

	function d3layer() {
	    var f = {}, bounds, feature, collection;
	    var div = d3.select(document.body)
	        .append("div")
	        .attr('class', 'd3-vec search-layer'),
	        svg = div.append('svg'),
	        g = svg.append("g");

	    f.parent = div.node();

	    f.project = function(x) {
	      var point = f.map.locationPoint({ lat: x[1], lon: x[0] });
	      return [point.x, point.y];
	    };

	    var first = true;
	    f.draw = function() {
	      first && svg.attr("width", f.map.dimensions.x)
	          .attr("height", f.map.dimensions.y)
	          .style("margin-left", "0px")
	          .style("margin-top", "0px") && (first = false);

	      path = d3.geo.path().projection(f.project);
	      feature.attr("d", path);
	    };

	    f.data = function(x) {
	        collection = x;
	        bounds = d3.geo.bounds(collection);
	        feature = g.selectAll("path")
	            .data(collection.features)
	            .enter().append("path");
	        return f;
	    };

	    f.extent = function() {
	        return new MM.Extent(
	            new MM.Location(bounds[0][1], bounds[0][0]),
	            new MM.Location(bounds[1][1], bounds[1][0]));
	    };
	    return f;
	}

})(jQuery);