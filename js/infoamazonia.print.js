var infoamazoniaPrint;

(function($) {

	infoamazoniaPrint = function(options, url) {

		settings = {
			layers: [],
			center: [0,0],
			zoom: 0,
			size: [640,300]
		};

		settings = $.extend(settings, options);

		var imageUrl;

		if(typeof url !== 'undefined') {
			imageUrl = url;
		} else {
			var baseUrl = 'http://a.tiles.mapbox.com/v3/';
			imageUrl = baseUrl + layers.join(',') + '/' + center.join(',') + '/' + size.join('x') + '.png';
		}

		$('.map-container').hide();
		$('#embed-map').append('<img id="map-image" src="' + imageUrl + '" />');

		$('body').imagesLoaded(function() {
			window.print();
		});

	}

})(jQuery);