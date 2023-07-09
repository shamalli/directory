(function($){
    SABAI.GoogleMaps = SABAI.GoogleMaps || {};
    SABAI.GoogleMaps.maps = SABAI.GoogleMaps.maps || {};
    SABAI.GoogleMaps.map = SABAI.GoogleMaps.map || function (mapId, markers, center, zoom, options, updater) {
        var $map,
            gmap,
            markers_count = markers.length,
            marker,
            currentMarker,
            markerPosition,
            markerCluster,
            markerIconOptions,
            infoboxWidth = options.infobox_width || 250,
            infobox = new InfoBox({
                boxClass: 'sabai-googlemaps-infobox sabai-box-shadow',
                disableAutoPan: false,
                closeBoxMargin: 0,
                closeBoxURL: 'https://www.google.com/intl/en_us/mapfiles/close.gif',
                infoBoxClearance: new google.maps.Size(30, 30),
                pixelOffset: new google.maps.Size(-1 * infoboxWidth / 2, -55),
                alignBottom: true,
                boxStyle: {
                    width: infoboxWidth + "px"
                }
            }),
            infoboxArrow = '<div class="sabai-googlemaps-infobox-arrow" style="left:' + ((infoboxWidth / 2) - 8) + 'px"></div>',
            i,
            bounds,
            mapTypeIds = [],
            mapType;
            
        $map = $(mapId);
        if (!$map.length) return;
        
        if (!center) {
            center = markers_count ? new google.maps.LatLng(markers[0].lat, markers[0].lng) : new google.maps.LatLng(options.default_lat || 40.69847, options.default_lng || -73.95144);
            if (markers_count > 1) {
                bounds = new google.maps.LatLngBounds();
            }
        } else {
            center = new google.maps.LatLng(center[0], center[1]);
            if (options.force_fit_bounds != false && markers_count > 0) {
                bounds = new google.maps.LatLngBounds();
            }
        }

        for(mapType in google.maps.MapTypeId) {
            mapTypeIds.push(google.maps.MapTypeId[mapType]);
        }
        mapTypeIds.push('osm');
        gmap = new google.maps.Map($map.get(0), {
            mapTypeControl: true,
            mapTypeId: $.inArray($map.data('map-type'), mapTypeIds) !== -1 ? $map.data('map-type') : google.maps.MapTypeId.ROADMAP,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                mapTypeIds: mapTypeIds
            },
            panControl: false,
            zoom: zoom,
            center: center,
            scrollwheel: options.scrollwheel != false,
            styles: SABAI.GoogleMaps.styles || [{'featureType': 'poi', 'stylers': [{'visibility': 'off'}]}]
        });
        gmap.mapTypes.set('osm', new google.maps.ImageMapType({
            getTileUrl: function(coord, zoom) {
                return '//tile.openstreetmap.org/' + zoom + '/' + coord.x + '/' + coord.y + '.png';
            },
            tileSize: new google.maps.Size(256, 256),
            isPng: true,
            maxZoom: 19,
            minZoom: 0,
            name: 'OSM'
        }));
        
        // Add markers
        if (markers_count > 0) {
            if (options.marker_clusters != false) {
                var marker_cluster_options = {maxZoom: 15};
                if (options.marker_cluster_imgurl) {
                    marker_cluster_options.imagePath = options.marker_cluster_imgurl + '/m';
                }
                markerCluster = new MarkerClusterer(gmap, [], marker_cluster_options);
            }            
            for (i = 0; i < markers_count; i++) {
                markerPosition = new google.maps.LatLng(markers[i].lat, markers[i].lng);
                marker = new google.maps.Marker({
                    position: markerPosition
                });
                if (markers[i].icon || options.icon) {
                    if (!markerIconOptions) {
                        markerIconOptions = {};
                        if (parseInt(options.marker_width) && parseInt(options.marker_height)) {
                            markerIconOptions.size = markerIconOptions.scaledSize = new google.maps.Size(parseInt(options.marker_width), parseInt(options.marker_height));
                        }
                    }
                    markerIconOptions.url = markers[i].icon || options.icon;
                    marker.setIcon(markerIconOptions);
                }
                if (bounds) {
                    bounds.extend(markerPosition);
                    if (options.force_fit_bounds != false) {
                        // Extend bound to include the point opposite the marker so the center stays the same
                        bounds.extend(new google.maps.LatLng(center.lat() * 2 - markers[i].lat, center.lng() * 2 - markers[i].lng));
                    }
                }
                google.maps.event.addListener(marker, options.marker_event || 'click', (function (marker, i) {
                    return function(e) {
                        if (currentMarker && currentMarker.get('id') === marker.get('id')) {
                            return;
                        }
                        gmap.panTo(marker.getPosition());
                        if (markerCluster && e.triggered) {
                            gmap.setZoom(16);
                            markerCluster.repaint();
                        }                        
                        if (currentMarker) {
                            currentMarker.setAnimation(null);
                        }
                        if ((!e.triggered || e.trigger_infobox) && markers[i].content) {
                            infobox.setContent(infoboxArrow + markers[i].content);
                            infobox.open(gmap, marker);
                            currentMarker = marker;
                        } else {
                            marker.setAnimation(google.maps.Animation.BOUNCE);
                            setTimeout(function() {
                                marker.setAnimation(null);
                            }, 1400);
                        }
                    }
                })(marker, i));
                if (markers[i].trigger) {
                    var marker_trigger = $(markers[i].trigger);
                    if (marker_trigger.length) {
                        var marker_trigger_event = markers[i].triggerEvent || 'mouseover';
                        marker_trigger[marker_trigger_event]((function (marker, i, trigger, event, trigger_infobox) {                        
                            return function () {
                                if (event === 'change' && trigger.val() != i) {
                                    if (trigger.val() === '') infobox.close();
                                    return;
                                }
                                google.maps.event.trigger(marker, options.marker_event || 'click', {triggered:true, trigger_infobox:trigger_infobox});
                                return false;
                            };
                        })(marker, i, marker_trigger, marker_trigger_event, markers[i].trigger_infobox));
                    }
                }
                marker.set('id', i);
                if (markerCluster) {
                    markerCluster.addMarker(marker);
                } else {
                    marker.setMap(gmap);
                }
                if (options.default_marker !== undefined && options.default_marker === i) {
                    setTimeout((function(marker) {
                        return function() {
                            google.maps.event.trigger(marker, options.marker_event || 'click', {init:true});
                        }
                    }(marker)), 1500);
                }
            }
            
            // Enable direction services?
            if (options.enable_directions) {
                var directions = $(options.enable_directions);
                if (!directions.length) return;
                
                var trigger = directions.find('.sabai-googlemaps-directions-trigger');
                if (!trigger.length) return;

                var destinationMarker, 
                    directionsPanel = directions.find('.sabai-googlemaps-directions-panel'),
                    directionsService = new google.maps.DirectionsService(),
                    directionsDisplay,
                    request;
                    
                // reset directions
                directions.find('.sabai-googlemaps-directions-panel').hide().end()
                    .find('.sabai-googlemaps-directions-input').val('').end()
                    .find('.sabai-googlemaps-directions-destination').val(0);
            
                trigger.click(function (e) {
                    e.preventDefault();
                    
                    var $this = $(this), 
                        destinationMarkerIndex = directions.find('.sabai-googlemaps-directions-destination').val();
                    if (destinationMarkerIndex === '' || !markers[destinationMarkerIndex]) return;
                
                    var origin = directions.find('.sabai-googlemaps-directions-input').val();
                    if (!origin) return;
                
                    infobox.close();
                    $this.addClass('sabai-disabled');
                    destinationMarker = markers[destinationMarkerIndex];
                    request = {
                        origin: origin,
                        destination: new google.maps.LatLng(destinationMarker.lat, destinationMarker.lng),
                        travelMode: google.maps.TravelMode[$this.data('travel-mode') || 'DRIVING']
                    };
                    directionsPanel.html('').hide();
                    if (directionsDisplay != null) {
                        directionsDisplay.setMap(null);
                        directionsDisplay = null;
                    }   
                    directionsDisplay = new google.maps.DirectionsRenderer({
                        map: gmap,
                        draggable: true,
                        panel: directionsPanel.get(0)
                    });
                    directionsService.route(request, function (response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                            SABAI.scrollTo(mapId);
                            directionsPanel.show().find('img.adp-marker').hide();
                        } else {
                            alert('No directions found');
                        }
                        $this.removeClass('sabai-disabled');
                    });
                });
            }
            
            // Clear current marker on closing infobox
            google.maps.event.addListener(infobox, 'closeclick', function () {
                currentMarker = null;
            });
            
            google.maps.event.addListener(infobox, 'clusteringbegin', function () {
                infobox.close();
                currentMarker = null;
            });
            
            if (bounds) gmap.fitBounds(bounds);
        }
        
        if (options.circle && options.circle.center && parseInt(options.circle.draw)) {
            var circle = new google.maps.Circle({
                strokeColor: options.circle.stroke_color || '#99f',
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: options.circle.fill_color || '#99f',
                fillOpacity: 0.3,
                map: gmap,
                center: new google.maps.LatLng(options.circle.center[0], options.circle.center[1]),
                radius: options.circle.is_mile ? options.circle.radius * 1609.344 : options.circle.radius * 1000
            });
            if (!bounds) gmap.fitBounds(circle.getBounds());
        }
        
        if (updater) {
            var updateTrigger = $(options.update_trigger || mapId + '-update');
            if (updateTrigger.length) {
                var updaterTimeout, update = function () {
                    if (!updateTrigger.prop('checked')) return;
                    updater.call(gmap, gmap.getCenter(), gmap.getBounds(), gmap.getZoom());
                };        
                // Update map when dragged or zoom changed
                google.maps.event.addListener(gmap, 'dragend', function () {
                    updaterTimeout = setTimeout(update, 1000);
                });
                google.maps.event.addListener(gmap, 'mousedown', function () {
                    if (updaterTimeout) clearTimeout(updaterTimeout);
                });
                if ($.cookie) {
                    updateTrigger.prop('checked', $.cookie('sabai_googlemaps_map_update')).click(function () {
                        if ($(this).prop('checked')) {
                            $.cookie('sabai_googlemaps_map_update', true, {expires: 7, path: SABAI.path, domain: SABAI.domain});
                        } else {
                            $.removeCookie('sabai_googlemaps_map_update');
                        }
                    });
                }
            }
        }
        
        SABAI.GoogleMaps.maps[mapId] = gmap;
        
        return gmap;
    };
    // For compat with SabaiDirectory 1.2.x
    SABAI.Directory = SABAI.Directory || {};
    SABAI.Directory.googleMap = function (mapId, markers, updater, center, zoom, styles, options) {
        SABAI.GoogleMaps.map(mapId, markers, center, zoom, styles, options, updater);
    }
})(jQuery);
