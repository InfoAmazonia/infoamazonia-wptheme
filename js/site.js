(function($) {

	/*
	 * Header
	 */

	$(document).ready(function() {

		$(window).scroll(function() {
			if($(window).scrollTop() > 20) {
				$('#masthead').addClass('collapsed');
			} else {
				$('#masthead').removeClass('collapsed');
			}
		});

	});

	/*
	 * Home slider
	 */
	$(document).ready(function() {

		if($('#slider').length) {

			var container = $('#slider .slider-content');
			var items = container.find('article');
			var active = items.first();

			active.addClass('active');

			var next = function() {

				active.removeClass('active');

				if(active.is('article:last-child')) {
					active = items.first();
				} else {
					active = active.next('article');
				}

				container.addClass('transition');

				setTimeout(function() {

					container
						.removeClass('transition')
						.css({
							'background-image': 'url(' + active.attr('data-image') + ')'
						});

					active.addClass('active');

				}, 400);

			}

			var t = setInterval(next, 8200);

		}

	});

})(jQuery);