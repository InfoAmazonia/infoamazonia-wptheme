(function($) {

	mappress.createCallback('markerCentered');

	var markers = function(map) {

		if(map.conf.disableMarkers || map.conf.admin)
			return false;

		map.markers = markers;

		var	layer,
			features = [],
			geojson,
			fragment = false,
			listPost,
			icon = L.Icon.extend({}),
			activeIcon = new icon(infoamazonia_markers.marker_active),
			activeMarker;

		// setup sidebar
		if(!map.conf.disableSidebar) {
			map.$.parents('.map-container').wrapAll('<div class="content-map" />');
			map.$.parents('.content-map').prepend('<div class="map-sidebar"><div class="sidebar-inner"></div></div>');
			map.$.sidebar = map.$.parents('.content-map').find('.sidebar-inner');
			map.invalidateSize(true);
		}

		if(typeof mappress.fragment === 'function' && !map.conf.disableHash)
			fragment = mappress.fragment();

		$.getJSON(infoamazonia_markers.ajaxurl,
		{
			action: 'markers_geojson',
			query: infoamazonia_markers.query
		},
		function(data) {
			geojson = data;
			if(geojson === 0)
				return;
			_build(geojson);
		});

		var _build = function(geojson) {

			var icons = {};

			var parentLayer;
			if(infoamazonia_markers.enable_clustering) {

				parentLayer = new L.MarkerClusterGroup({
					maxClusterRadius: 20,
					iconCreateFunction: function(cluster) {
        				return new L.DivIcon({ html: '<b class="story-points">' + cluster.getChildCount() + '</b>' });
   					}
				});

			} else {
				parentLayer = new L.layerGroup();
			}

			map.addLayer(parentLayer);

			layer = L.geoJson(geojson, {
				pointToLayer: function(f, latLng) {

					var marker = new L.marker(latLng);
					features.push(marker);
					return marker;

				},
				onEachFeature: function(f, l) {

					if(f.properties.marker.markerId) {

						if(icons[f.properties.marker.markerId]) {
							var fIcon = icons[f.properties.marker.markerId];
						} else {
							var fIcon = new icon(f.properties.marker);
							icons[f.properties.marker.markerId] = fIcon;
						}

						l.markerIcon = fIcon;

						l.setIcon(fIcon);

					}

					l.bindPopup(f.properties.bubble);

					l.on('mouseover', function(e) {
						e.target.previousOffset = e.target.options.zIndexOffset;
						e.target.setZIndexOffset(1500);
						e.target.openPopup();
					});
					l.on('mouseout', function(e) {
						e.target.setZIndexOffset(e.target.previousOffset);
						e.target.closePopup();
					});
					l.on('click', function(e) {
						markers.open(e.target, false);
						return false;
					});

				}

			});

			map._markerLayer = layer;

			layer.addTo(parentLayer);

			if(map.conf.sidebar === false)
				return;

			/*
			 * SIDEBAR STUFF (INFOAMAZONIA)
			 */

			// FIRST STORY
			var story = features[0];
			var silent = false;

			// if not home, navigate to post
			if(!infoamazonia_markers.home) 
				silent = false;

			if(fragment) {
				var fStoryID = fragment.get('story');
				if(fStoryID) {
					var found = _.any(features, function(c) {
						if(c.toGeoJSON().properties.id == fStoryID) {
							story = c;
							if(fragment.get('loc'))
								silent = true;
							return true;
						}
					});
					if(!found) {
						fragment.rm('story');
					}
				}
			}

			// bind list post events
			listPosts = $('.list-posts');
			if(listPosts.length) {
				listPosts.find('li').click(function() {
					var markerID = $(this).attr('id');
					document.body.scrollTop = 0;
					markers.open(markerID, false);
					return false;
				});

				if(!fStoryID)
					story = listPosts.find('li:nth-child(1)').attr('id');
			}

			Shadowbox.init({
				skipSetup: true
			});

			if(map.conf.forceCenter)
				silent = true;

			markers.open(story, silent);
			mappress.runCallbacks('markersReady', [map]);

		};

		markers.open = function(marker, silent) {

			if(activeMarker instanceof L.Marker) {
				activeMarker.setIcon(activeMarker.markerIcon);
				activeMarker.setZIndexOffset(0);
			}

			// if marker is string, get object
			var markerID = false;
			if(typeof marker === 'string') {
				markerID = marker;
				marker = _.find(features, function(m) { return m.toGeoJSON().properties.id === markerID; });
			}

			if(markerID && !marker)
				marker = _.find(geojson.features, function(f) { return f.properties.id === markerID; });

			if(marker instanceof L.Marker) {
				activeMarker = marker;
				marker.setIcon(activeIcon);
				marker.setZIndexOffset(1000);
				marker.previousOffset = 1000;
				marker = marker.toGeoJSON();
			}

			if(map.conf.sidebar === false) {
				window.location = marker.properties.url;
				return false;
			}

			if(fragment) {
				if(!silent)
					fragment.set({story: marker.properties.id});
			}

			if(typeof _gaq !== 'undefined') {
				_gaq.push(['_trackPageView', location.pathname + location.search + '#!/story=' + marker.properties.id]);
			}

			if(!silent) {

				var center,
					zoom;

				if(marker.geometry) {
					center = [
						marker.geometry.coordinates[1],
						marker.geometry.coordinates[0]
					];
					if(map.getZoom() < 7) {
						zoom = 7;
						if(map.conf.maxZoom < 7)
							zoom = map.conf.maxZoom;
					} else {
						zoom = map.getZoom();
					}
				} else {
					center = map.conf.center;
					zoom = map.conf.zoom;
				}

				var viewOptions = {
					animate: true,
					duration: 1,
					pan: {
						animate: true,
						duration: 1
					},
					zoom: { animate: true }
				};

				if(window.location.hash == '#print') {
					viewOptions = {
						animate: false,
						duration: 0,
						pan: {
							naimate: false,
							duration: 0
						},
						zoom: { animate: false }
					};
				}

				map.setView(center, zoom, viewOptions);
				if(fragment) {
					fragment.rm('loc');
				}
			}

			mappress.runCallbacks('markerCentered', [map]);

			// populate sidebar
			if(map.$.sidebar && map.$.sidebar.length) {

				var permalink_slug = marker.properties.permalink.replace(infoamazonia_markers.site_url, '');
				marker.properties.permalink = infoamazonia_markers.site_url + infoamazonia_markers.language + '/' + permalink_slug;

				if(!map.$.sidebar.story) {
					map.$.sidebar.append('<div class="story" />');
					map.$.sidebar.story = map.$.sidebar.find('.story');
				}

				map.$.find('.story-points').removeClass('active');
				var $point = map.$.find('.story-points.' + marker.properties.id);
				$point.addClass('active');

				var storyData = marker.properties;

				// slideshow label
				var media = false;
				if(typeof storyData.slideshow === 'object') {

					media = storyData.slideshow;

					var lightbox_label = infoamazonia_markers.lightbox_label.slideshow;

					if(!media.images && media.iframes) {
						// iframes can be video, infographic or image gallery

						// separate them
						var infographics = _.filter(media.iframes, function(iframe) { return iframe.type === 'infographic'; });
						var galleries = _.filter(media.iframes, function(iframe) { return iframe.type === 'image-gallery'; });
						var videos = _.filter(media.iframes, function(iframe) { return iframe.type === 'video'; });

						if((videos.length && galleries.length) || (videos.length && infographics.length) || (galleries.length && infographics.length)) {

							lightbox_label = infoamazonia_markers.lightbox_label.slideshow;

						} else {

							if(videos.length) {
								if(videos.length >= 2)
									lightbox_label = infoamazonia_markers.lightbox_label.videos;
								else
									lightbox_label = infoamazonia_markers.lightbox_label.video;
							}
							if(galleries.length) {
								lightbox_label = infoamazonia_markers.lightbox_label.images;
							}
							if(infographics.length) {
								if(infographics.length >= 2)
									lightbox_label = infoamazonia_markers.lightbox_label.infographics;
								else
									lightbox_label = infoamazonia_markers.lightbox_label.infographic;
							}

						}

					} else if(media.images && !media.iframes) {
						if(media.images.length >= 2)
							lightbox_label = infoamazonia_markers.lightbox_label.images;
						else
							lightbox_label = infoamazonia_markers.lightbox_label.image;
					}
				}

				var story = '';
				story += '<small>' + storyData.date + ' - ' + storyData.source + '</small>';
				story += '<h2>' + storyData.title + '</h2>';
				if(storyData.thumbnail)
					story += '<div class="media-limit"><img class="thumbnail" src="' + storyData.thumbnail + '" /></div>';
				if(media)
					story += '<a class="button open-slideshow" href="#">' + lightbox_label + '</a>';
				story += '<div class="story-content">' + storyData.content + '</div>';
				story += ' <a href="' + storyData.url + '" target="_blank" rel="external">' + infoamazonia_markers.read_more_label + '</a>';

				var $story = $(story);

				map.$.sidebar.story.empty().append($story);

				// adjust thumbnail image
				map.$.sidebar.imagesLoaded(function() {

					var $sidebar = map.$.sidebar;

					if(!$sidebar.find('.media-limit'))
						return;

					var containerHeight = $sidebar.find('.media-limit').height();
					var imageHeight = $sidebar.find('.media-limit img').height();

					var topOffset = (containerHeight - imageHeight) / 2;

					if(topOffset < 0) {
						$sidebar.find('.media-limit img').css({
							'margin-top': topOffset
						});
					}

				});

				if(media) {

					var shadowboxMedia = [];

					if(media.images) {
						$.each(media.images, function(i, image) {
							shadowboxMedia.push({
								content: image,
								player: 'img'
							});
						});
					}
					if(media.iframes) {
						$.each(media.iframes, function(i, iframe) {
							shadowboxMedia.push({
								content: iframe.src,
								width: iframe.width,
								height: iframe.height,
								player: 'iframe'
							})
						});
					}

					map.$.sidebar.story.find('.open-slideshow').click(function() {
						Shadowbox.open(shadowboxMedia);
						return false;
					});

				}

				// add share button
				if(!map.$.sidebar.share) {

					map.$.sidebar.append('<div class="sharing" />');
					map.$.sidebar.share = map.$.sidebar.find('.sharing');

					var shareContent = '';
					shareContent += '<a class="button embed-button" href="#" target="_blank">' + infoamazonia_markers.embed_label + '</a>';
					shareContent += '<a class="button print-button" href="#" target="_blank">' + infoamazonia_markers.print_label + '</a>';
					shareContent += '<div class="social">';
					shareContent += '<div class="twitter-button"></div>';
					shareContent += '<div class="fb-like"></div>';
					shareContent += '</div>';

					map.$.sidebar.share.append(shareContent);

				}

				map.$.sidebar.share.find('.share-options').hide().addClass('hidden');

				var share_vars = '?p=' + marker.properties.postID;
				var map_id = map.postID;
				if(map.currentMapID)
					map_id = map.currentMapID;

				if(typeof map_id === 'undefined') {
					share_vars += '&layers=' + map.conf.layers;
				} else {
					share_vars += '&map_id=' + map_id;
				}

				var embed_url = infoamazonia_markers.share_base_url + share_vars;
				var print_url = infoamazonia_markers.embed_base_url + share_vars + '&print=1' + '#print';

				map.$.sidebar.share.find('.embed-button').attr('href', embed_url);
				map.$.sidebar.share.find('.print-button').attr('href', print_url);

				if(map.currentMapID) {

					mappress.groupChanged(function(mapID, group) {

						share_vars = '?p=' + marker.properties.postID + '&map_id=' + mapID;

						embed_url = infoamazonia_markers.share_base_url + share_vars;
						print_url = infoamazonia_markers.embed_base_url + share_vars + '&print=1' + '#print';

						map.$.sidebar.share.find('.embed-button').attr('href', embed_url);
						map.$.sidebar.share.find('.print-button').attr('href', print_url);

						var share_url = window.location.protocol + "//" + window.location.host + window.location.pathname + window.location.hash;
						if(window != window.top)
							share_url = marker.properties.permalink;

						var fb_vars = {
							href: share_url,
							show_faces: false,
							colorscheme: 'light',
							action: 'recommend',
							appId: '459964104075857',
							height: 20,
							layout: 'button_count'
						}
						
						// fb
						map.$.sidebar.share.find('.fb-like').html('<iframe src="//www.facebook.com/plugins/like.php?' + $.param(fb_vars) + '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:20px;" allowTransparency="true"></iframe>');
						map.$.sidebar.share.find('.twitter-button').empty();
						twttr.widgets.createShareButton(share_url, $('.twitter-button').get(0), null, {
							lang: infoamazonia_markers.language,
							via: 'InfoAmazonia',
							text: marker.properties.title
						});

					});

				}

				

				var share_url = window.location.protocol + "//" + window.location.host + window.location.pathname + window.location.hash;
				if(window != window.top)
					share_url = marker.properties.permalink;

				var fb_vars = {
					href: share_url,
					show_faces: false,
					colorscheme: 'light',
					action: 'recommend',
					appId: '459964104075857',
					height: 20,
					layout: 'button_count'
				}

				// fb
				map.$.sidebar.share.find('.fb-like').html('<iframe src="//www.facebook.com/plugins/like.php?' + $.param(fb_vars) + '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:20px;" allowTransparency="true"></iframe>');
				map.$.sidebar.share.find('.twitter-button').empty();
				twttr.widgets.createShareButton(share_url, $('.twitter-button').get(0), null, {
					lang: infoamazonia_markers.language,
					via: 'InfoAmazonia',
					text: marker.properties.title
				});

			}

			// activate post in post list
			var postList = $('.list-posts');
			if(postList.length) {
				postList.find('li').removeClass('active');
				var item = postList.find('#' + marker.properties.id);
				if(item.length) {
					item.addClass('active');
				}
			}
		};
	}

	mappress.mapReady(markers);
	mappress.createCallback('markersReady');

})(jQuery);