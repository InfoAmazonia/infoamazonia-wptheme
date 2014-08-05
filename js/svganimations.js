(function($) {

	$(document).ready(function() {

		var animatePath = function(path, fps, cb) {

			fps = fps || 100;

			var current = 0,
				handle = 0,
				length = path[0].getTotalLength();

			path.css({
				strokeDasharray: length + ' ' + length,
				strokeDashoffset: length
			});

			var draw = function() {
				var progress = current/fps;
				if(progress > 1) {
					window.cancelAnimationFrame(handle);
					if(typeof cb == 'function')
						cb();
				} else {
					current++;
					path.css({
						strokeDashoffset: Math.floor(length * (1 - progress))
					});
					handle = window.requestAnimationFrame(draw);
				}
			};

			draw();

		}

		var animateSvgPaths = function(svg, fps) {

			var paths = svg.find('path');

			paths.each(function() {
				animatePath($(this), fps);
			});

		};

		var scrollLocate = function(block, cb) {

			var halfWindow = $(window).height() / 2;

			$(window).scroll(function() {

				if(block.is(':visible')) {

					var relTop = block.offset().top - $(window).scrollTop();
					var relBottom = relTop + block.innerHeight();

					if(relTop <= (halfWindow - (block.height()/2) + 100) && relBottom >= halfWindow) {

						block.addClass('onscreen');

						setTimeout(function() {
							block.addClass('appeared');
						}, 500);

						cb();

					} else {

						block.removeClass('onscreen');
					}

				}

			});

		};

		/*
		 * DATA
		 */

		(function() {

			// snap
			var svg = $('#svg_data');

			svg.find('.chart,.data-container').each(function() {
				var l = $(this)[0].getTotalLength();
				$(this).css({
					strokeDasharray: l + ' ' + l,
					strokeDashoffset: l
				});
			});

			var sVBars = [
				Snap('.v-bar-1'),
				Snap('.v-bar-2'),
				Snap('.v-bar-3')
			];

			var sVVals = [
				[22.013, 15.918],
				[13.493, 24.438],
				[5.5050001, 32.425999]
			];

			_.each(sVBars, function(sVBar, i) {

				sVBar.attr({
					height: 0,
					y: sVVals[i][1] - sVVals[i][0]
				});

			});

			var sHBars = [
				Snap('.h-bar-1'),
				Snap('.h-bar-2'),
				Snap('.h-bar-3')
			];

			Snap('.data-container').attr({'fill-opacity': 0});
			Snap('.chart.part-1').attr({'fill-opacity':0});
			Snap('.chart.part-2').attr({'fill-opacity':0});
			Snap('.chart.part-3').attr({'fill-opacity':0});

			_.each(sHBars, function(sHBar, i) {

				sHBar.attr({width: 0});

			});

			scrollLocate($('#data_block'), _.once(function() {

				_.each(sHBars, function(sHBar, i) {

					var timeBtwn = i * 200;

					var duration = 1000 - timeBtwn;

					setTimeout(function() {

						sHBar.animate({width: 37.807999}, duration);

					}, timeBtwn);

				});

				_.each(sVBars, function(sVBar, i) {

					sVBar.animate({height: sVVals[i][0], y: sVVals[i][1]}, 1000);

				});

				setTimeout(function() {
					animatePath(svg.find('.chart'), 40, function() {
						Snap('.chart.part-1').animate({'fill-opacity': '1', 'stroke-width': 0}, 500);
						Snap('.chart.part-2').animate({'fill-opacity': '1', 'stroke-width': 0}, 500);
						Snap('.chart.part-3').animate({'fill-opacity': '1', 'stroke-width': 0}, 500);
						animatePath(svg.find('.data-container'), 100, function() {
							Snap('.data-container').animate({'fill-opacity': '1', 'stroke-width': 0}, 500);
						});
					});

				}, 1000);

			}));

		})();

		/*
		 * MAP + DESIGN + DATA
		 */

		(function() {

			var id = '#svg_map_data_design';
			var svg = $(id);

			svg.find('.amazon').each(function() {
				var l = $(this)[0].getTotalLength();
				$(this).css({
					strokeDasharray: l + ' ' + l,
					strokeDashoffset: l
				});
			});

			Snap(id + ' .amazon').attr({'fill-opacity': 0});
			//Snap(id + ' .countries').attr({'opacity': 0});
			Snap(id + ' .data-content').attr({'fill-opacity': 0});
			Snap(id + ' .data-content').attr({'stroke-opacity': 0});
			Snap(id + ' .plus tspan').attr({'fill-opacity': 0});
			Snap(id + ' .design-content').attr({'fill-opacity': 0});
			Snap(id + ' .design-content').attr({'stroke-opacity': 0});

			scrollLocate($('#map_block'), _.once(function() {
				animatePath(svg.find('.amazon'), 60, function() {
					Snap(id + ' .amazon').animate({
						'fill-opacity': .08
					}, 500);
					Snap(id + ' .data-content').animate({
						'transform': 'translate(10,0)',
						'fill-opacity': 1
					}, 500);
					Snap(id + ' .design-content').animate({
						'transform': 'translate(-10,0)',
						'fill-opacity': 1
					}, 500);
					setTimeout(function() {
						Snap(id + ' .countries').animate({
							'opacity': 1
						});
						Snap(id + ' .plus tspan').animate({
							'fill-opacity': 1
						}, 500);
					}, 500);
				});
			}));

		})();

		/*
		 * Network
		 */

		(function() {

			var svg = $('#svg_network');

			svg.find('.network path').css({'stroke-width': 0});
			svg.find('.circle path').css({'fill-opacity': 0});
			svg.find('.ia-icon').css({'fill-opacity': 0});

			scrollLocate($('#network_block'), _.once(function() {

				svg.find('.network path').css({'stroke-width': .2});

				animatePath(svg.find('.network path'), null, function() {
			
					Snap('#svg_network .circle path').animate({
						'fill-opacity': .1
					}, 500);
			
					Snap('#svg_network .ia-icon').animate({
						'fill-opacity': 1,
						'stroke-width': 0
					}, 500);

					Snap('#svg_network .network path').animate({
						'fill-opacity': 1
					}, 500);

				});

			}));

		})();

	});

})(jQuery);