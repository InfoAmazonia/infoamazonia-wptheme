jQuery(function($) {

	$.fn.infoamazoniaGeocodeBox = function(settings) {


		var config = {
			resultsContainer: $(this).find('.geocode-result'),
			addressInput: $(this).find('.geocoded-address'),
			latitudeInput: $(this).find('.geocoded-latitude'),
			longitudeInput: $(this).find('.geocoded-longitude')
		}

		if(settings) $.extend(config, settings);

		config.resultsContainer.hide();

		$(this).find('.open-geocode-box').click(function() {
			$('#geocode-box').addClass('active');
			$('#geocode-box #geocode_address').val(config.addressInput.val());
			geocodeBox();
		});

		$('#geocode-box .close-geocode').click(function() {
			$('#geocode-box').removeClass('active');
			return false;
		});

		$('#geocode-box .finish-geocode-box').click(function() {
			sendData();
			$('#geocode-box').removeClass('active');
			return false;
		});

		function sendData() {
			var address = $('#geocode-box #geocode_address').val();
			var lat = $('#geocode-box #geocode_lat').val();
			var lon = $('#geocode-box #geocode_lon').val();

			config.addressInput.each(function() {
				storeElVal($(this), address);
			})

			config.latitudeInput.each(function() {
				storeElVal($(this), lat);
			});

			config.longitudeInput.each(function() {
				storeElVal($(this), lon);
			});

			config.resultsContainer.show();
		}

		function storeElVal($el, val) {
			if($el.is('input')) {
				$el.val(val);
			} else {
				$el.html(val);
			}
		}

	}

});