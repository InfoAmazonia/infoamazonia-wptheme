(function($) {

	/*
	 * Header
	 */

	$(document).ready(function() {

		$(window).scroll(function() {
			if($(window).scrollTop() > 20) {
				$('#masthead').addClass('collapsed');
				if($('#masthead').find('.scrolled-header').length) {
					$('#masthead .scrolled-header').show();
					$('#masthead .regular-header').hide();
				}
			} else {
				$('#masthead').removeClass('collapsed');
				if($('#masthead').find('.scrolled-header').length) {
					$('#masthead .scrolled-header').hide();
					$('#masthead .regular-header').show();
				}
			}
		});

		$(window).scroll();

	});

	/*
	 * Home slider
	 */
	$(document).ready(function() {

		if($('#slider').length) {

			var container = $('#slider .slider-content');
			var items = container.find('article');
			var active = items.first();
			var selectors = container.find('.selector');

			selectors.appendTo('#slider-nav .slider-nav-content');

			var activeSelector = selectors.first();

			active.addClass('active');
			activeSelector.addClass('active');

			var open = function(item) {

				items.removeClass('active');
				selectors.removeClass('active');

				active = item;

				activeSelector = selectors.filter('[data-item="' + active.attr('id') + '"]');

				container.addClass('transition');

				setTimeout(function() {

					container
						.removeClass('transition')
						.css({
							'background-image': 'url(' + active.attr('data-image') + ')'
						});

					active.addClass('active');
					activeSelector.addClass('active');

				}, 400);

			};

			var next = function() {

				if(active.is('article:last-child')) {
					active = items.first();
				} else {
					active = active.next('article');
				}

				open(active);

			}

			$(selectors).on('click', function() {

				active = items.filter('#' + $(this).attr('data-item'));
				open(active);

				clearInterval(t);
				t = setInterval(next, 8000);

				return false;

			});

			var t = setInterval(next, 8000);

		}

	});

})(jQuery);
