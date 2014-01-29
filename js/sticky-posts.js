(function($) {

	jeo.markersReady(function(map) {

		var t;

		function openSticky(postid) {

			var item = $('.sticky-posts .sticky-item[data-postid="' + postid + '"]');

			map.markers.focusMarker('post-' + postid);

			$('.sticky-posts').addClass('post-active');
			$('.sticky-posts .sticky-item').removeClass('active');
			item.addClass('active');
			
			adjustImageSize();

		}

		function closeSticky() {
			$('.sticky-posts').removeClass('post-active');
			$('.sticky-posts .sticky-item').removeClass('active');
			
			adjustImageSize();
		}

		function runSticky() {

			var current = $('.sticky-posts .sticky-item.active');

			if(!current.length) {
				var toGo = $('.sticky-posts .sticky-item:first-child');
			} else {
				if(current.is(':last-child'))
					var toGo = $('.sticky-posts .sticky-item:first-child');
				else
					var toGo = current.next('.sticky-item');
			}

			openSticky(toGo.data('postid'));

		}
		
		function adjustImageSize() {

			var opened = $('.sticky-posts .sticky-item.active img');
			var closed = $('.sticky-posts .sticky-item img');
			
			if(opened.length) {
				//opened.attr('style', '');
			}

			closed.each(function() {
				
				var img = $(this);
				
				if(!img.parents('.sticky-item').is('.active')) {
					
					var imgT = setInterval(function() {
						img.css({
							width: img.parents('.sticky-item').innerHeight(),
							height: img.parents('.sticky-item').innerHeight()
						});
					}, 10);
					
					setTimeout(function() {
						clearInterval(imgT);
					}, 250);
					
				} else {
					img.attr('style', '');
				}
				
			});
			
		}

		$('.sticky-posts .sticky-item').click(function() {
			clearInterval(t);
			if(!$(this).is('.active')) {
				openSticky($(this).data('postid'));
				return false;
			}
		});

		if($('.sticky-posts').length) {

			jeo.markerOpened(function() {
				clearInterval(t);
				closeSticky();
			});

			$('.sticky-posts .sticky-item').each(function() {

				var $item = $(this);
				$item.data('shareUrl', $(this).find('.share-button').attr('href'));
				$item.find('.share-button').attr('href', $item.data('shareUrl') + '&map_id=' + map.currentMapID);

			});

			jeo.groupChanged(function(group) {

				$('.sticky-posts .sticky-item').each(function() {
					var $item = $(this);
					$item.find('.share-button').attr('href', $item.data('shareUrl') + '&map_id=' + group.currentMapID);
				});

			});

			map.on('click mouseup', function() {
				clearInterval(t);
			});

			setTimeout(function() {
				openSticky($('.sticky-posts .sticky-item:first-child').data('postid'));
				t = setInterval(runSticky, 8000);
			}, 800);

		}

	});

})(jQuery);