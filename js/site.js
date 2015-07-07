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
				if($('#top-map').length) {
					$('#top-map').show();
				}
			} else {
				$('#masthead').removeClass('collapsed');
				if($('#masthead').find('.scrolled-header').length) {
					$('#masthead .scrolled-header').hide();
					$('#masthead .regular-header').show();
				}
				if($('#top-map').length) {
					$('#top-map').hide();
				}
			}
		});

		$(window).scroll();

	});

	/*
	 * Post sidebar offset
	 */
	$(document).ready(function() {
		if($('.post-content .post-description').length && $('.post-sidebar').length) {
			if($('.post-content .post-description').height() > 600) {
				$('.post-sidebar').addClass('offset');
			}
		}
	});

	/*
	 * Side map
	 */
	$(document).ready(function() {
		if($('.side-map').length) {
			var container = $('.side-map');
			var sizing = function() {
				var offset = container.offset().left;
				var winWidth = $(window).width();
				var width = winWidth - offset -20;
				container.width(width);
			};
			sizing();
			$(window).resize(sizing);
		}
	});

	/*
	 * Top map
	*/
	$(document).ready(function() {
		if($('#top-map').length) {
			var map;
			jeo.mapReady(function(m) {
				map = m;
			});
			var container = $('#top-map');
			$('.toggle-top-map').on('click', function() {
				if(container.hasClass('active')) {
					container.removeClass('active');
				} else {
					container.addClass('active');
				}
				map.invalidateSize(false);
				setTimeout(function() {
					map.invalidateSize(false);
				}, 205);
			});
		}
	})

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
