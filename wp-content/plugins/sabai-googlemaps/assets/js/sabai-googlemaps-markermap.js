(function($){
    SABAI.GoogleMaps = SABAI.GoogleMaps || {};
    SABAI.GoogleMaps.markerMap = SABAI.GoogleMaps.markerMap || function (field, lang, cloneable) {
        var $field = $(field),
        $address = $field.find('.sabai-googlemaps-address'),
        $map = $field.find('.sabai-googlemaps-map'),
        map,
        overlay,
        geocoder,
        getCallbacks = function () {
            return SABAI.GoogleMaps.markerMapAddress;
        },
        getGeocoder = function () {
            if (!geocoder) geocoder = new google.maps.Geocoder();
            return geocoder;
        },
        updateValues = function (latlng) {
            $map.find('.sabai-googlemaps-map-zoom').val(map.getZoom());
            $map.find('.sabai-googlemaps-map-lat').val(latlng.lat());
            $map.find('.sabai-googlemaps-map-lng').val(latlng.lng());
            fetchAddress();
        },
        updateAll = function (latlng) {
            overlay.setPosition(latlng);
            overlay.setAnimation(google.maps.Animation.BOUNCE);
            window.setTimeout(function() {
                overlay.setAnimation(null);
                map.panTo(latlng);
                updateValues(latlng);
            }, 1000);
        },
        fetchAddress = function (forceFormatted) {
            var latlng;
            latlng = overlay.getPosition();
            if (!latlng) {
                return;
            }
            getGeocoder().geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        if (results[0].address_components) {
                            var geocoded = {};
                            for (var i in results[0].address_components) {
                                if (typeof(results[0].address_components[i]) !== 'object'
                                    || !results[0].address_components[i].types[0]
                                    || !results[0].address_components[i].long_name
                                ) continue;

                                geocoded[results[0].address_components[i].types[0]] = {
                                    value: results[0].address_components[i].long_name,
                                    short_value: results[0].address_components[i].short_name
                                }
                            }
                        }
                        var formatted_address = $field.find('.sabai-googlemaps-formatted-address');
                        if (formatted_address.length && (forceFormatted || !formatted_address.val())) {
                            formatted_address.val(results[0].formatted_address || '');
                        }
                        $address.find('[class^="sabai-googlemaps-address-"]').filter(':input:visible').val('');
                        getCallbacks().setAddress($address, geocoded, lang);
                    } else {
                        alert('Geocoder returned no address components');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        },
        mapType,
        mapTypeIds = [];

        for(mapType in google.maps.MapTypeId) {
            mapTypeIds.push(google.maps.MapTypeId[mapType]);
        }
        mapTypeIds.push('osm');
        map = new google.maps.Map($map.find('.sabai-googlemaps-map-map').get(0), {
            mapTypeControl: true,
            mapTypeId: $.inArray($map.data('map-type'), mapTypeIds) !== -1 ? $map.data('map-type') : google.maps.MapTypeId.ROADMAP,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                mapTypeIds: mapTypeIds
            },
            zoom: $map.data('zoom'),
            center: new google.maps.LatLng($map.data('center-lat'), $map.data('center-lng')),
            scrollwheel: false,
            styles: null
        });
        map.mapTypes.set('osm', new google.maps.ImageMapType({
            getTileUrl: function(coord, zoom) {
                return '//tile.openstreetmap.org/' + zoom + '/' + coord.x + '/' + coord.y + '.png';
            },
            tileSize: new google.maps.Size(256, 256),
            isPng: true,
            maxZoom: 19,
            minZoom: 0,
            name: 'OSM'
        }));
        overlay = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        }) 
        if ($map.data('lat') && $map.data('lng')) {
            overlay.setPosition(new google.maps.LatLng($map.data('lat'), $map.data('lng')));
        }
        google.maps.event.addListener(map, 'click', function(event) {
            updateAll(event.latLng);
        });
        google.maps.event.addListener(map, 'zoom_changed', function(event) {
            // update zoom
            $map.find('.sabai-googlemaps-map-zoom').val(map.getZoom());
        });
        google.maps.event.addListener(overlay, 'dragend', function(event) {
            window.setTimeout(function() {
                map.panTo(event.latLng);
                updateValues(event.latLng);
            }, 1000);
        });
        $map.find('.sabai-googlemaps-map-lat, .sabai-googlemaps-map-lng').change(function(){
            var lat = $map.find('.sabai-googlemaps-map-lat').val(), lng = $map.find('.sabai-googlemaps-map-lng').val();
            if (lat && lng) {
                google.maps.event.trigger(map, 'click', {latLng: new google.maps.LatLng(lat, lng)});
            }
        });
        $map.find('.sabai-googlemaps-map-map').fitMaps();
        
        $field.find('.sabai-googlemaps-find-on-map').click(function(){
            var address = $field.find('.sabai-googlemaps-formatted-address');
            if (!address.length) return false;
            getGeocoder().geocode({'address': $.trim(address.val())}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    updateAll(results[0].geometry.location);
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
            return false;
        });
        $field.find('.sabai-googlemaps-get-from-map').click(function(){
            fetchAddress(true);
            return false;
        });
        if (navigator.geolocation) {
            var address = $field.find('.sabai-googlemaps-formatted-address');
            if (address.length) {
                var button = $('<span style="position:absolute; right:0; cursor:pointer; width:24px; height:24px; padding:4px; margin-right:1px;"><img style="vertical-align:baseline !important;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQBAMAAADt3eJSAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAAA/AAAAPwFHl4ngAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAADBQTFRF////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAL92gewAAAA90Uk5TAAYTOklcfYiNkZ+oueHn8F/YJAAAAE9JREFUCFtjYGBgYC9ggAAYg7n3hgGIZpyX4vZSAMjgPBS1VGcCkGGn/f//psdARlv8//9fMxgYyq+s////l285ggGXQiiGa4cbCLcC3XYA7R8qgYIYH20AAAAASUVORK5CYII6c7cb9f3bd9ed4aaf8b60b0d7d242d61="/></span>');
                button.insertAfter(address);
                var top = (address.outerHeight() - button.outerHeight()) / 2 + parseInt(address.css('margin-top'));
                button.css('top', top + 'px').click(function(e){
                    var $this = $(this);
                    SABAI.ajaxLoader(address);
                    geocoder = new google.maps.Geocoder();
                    navigator.geolocation.getCurrentPosition(
                        function (pos) {
                            geocoder.geocode({latLng: new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude)}, function(results, status) {
                                SABAI.ajaxLoader($this, true);
                                if (status == google.maps.GeocoderStatus.OK) {
                                    address.val(results[0].formatted_address).effect("highlight", {}, 2000);
                                    updateAll(new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude));
                                }
                            });
                            SABAI.ajaxLoader(address, true);
                        },
                        function (error) {
                            SABAI.ajaxLoader(address, true);
                            SABAI.console.log(error.message + " (" + error.code + ")");
                        },
                        {enableHighAccuracy:true, timeout:5000}
                    );
                    return false;
                });
            }
        }
        
        if (cloneable) {
            $(SABAI).bind('clonefield.sabai', function (e, data) {
                if (data.clone.hasClass('sabai-form-type-googlemaps-marker') || data.clone.hasClass('sabai-googlemaps-form-container')) {
                    data.clone.find('.sabai-googlemaps-map').data('lat', null).data('lng', null);
                    SABAI.GoogleMaps.markerMap(data.clone, lang, false);
                }
            });
        }
    };
    SABAI.GoogleMaps.markerMapAddress = {
        _loadVal: function (address, val, selector) {
            var field = address.find(selector);
            if (field.get(0).tagName.toLowerCase() === 'select') {
                field.val(val.short_value);
            } else {
                field.val(val.value);
            }
        },
        _setAddress: function (address, geocoded, lang) {
            var street_address;
            if (geocoded.street_address) {
                street_address = geocoded.street_address.val();
            } else if (geocoded.route) {
                if (geocoded.street_number) {
                    street_address = geocoded.street_number.value + ' ' + geocoded.route.value;
                } else {
                    street_address = geocoded.route.value;
                }
            }
            address.find('.sabai-googlemaps-address-street').val(street_address);
        },
        setAddress: function (address, geocoded, lang) {
            var country;
            for (var key in geocoded) {
                switch (key) {
                    case 'sublocality':
                    case 'locality':
                        SABAI.GoogleMaps.markerMapAddress._loadVal(address, geocoded[key], '.sabai-googlemaps-address-city');
                        break;
                    case 'administrative_area_level_1':
                        SABAI.GoogleMaps.markerMapAddress._loadVal(address, geocoded[key], '.sabai-googlemaps-address-province');
                        break;
                    case 'postal_code':
                        SABAI.GoogleMaps.markerMapAddress._loadVal(address, geocoded[key], '.sabai-googlemaps-address-zip');
                        break;
                    case 'country':
                        country = geocoded[key].short_value;
                        SABAI.GoogleMaps.markerMapAddress._loadVal(address, geocoded[key], '.sabai-googlemaps-address-country');
                        break;
                }
            }
            if (country && SABAI.GoogleMaps.markerMapAddress[country] && SABAI.GoogleMaps.markerMapAddress[country].setAddress) {
                SABAI.GoogleMaps.markerMapAddress[country].setAddress(address, geocoded, lang);
            } else {
                SABAI.GoogleMaps.markerMapAddress._setAddress(address, geocoded, lang);
            }
        },
        JP: {
            setAddress: function (address, geocoded, lang) {
                var street_address, ward = '', sublocality_level_1 = '', sublocality_level_2 = '', sublocality_level_3 = '', sublocality_level_4 = '', sublocality_level_5 = '';
                for (var key in geocoded) {
                    switch (key) {
                        case 'ward':
                            ward = geocoded[key].value;
                            break;
                        case 'sublocality_level_1':
                            sublocality_level_1 = geocoded[key].value;
                            break;
                        case 'sublocality_level_2':
                            sublocality_level_2 = geocoded[key].value;
                            break;
                        case 'sublocality_level_3':
                            sublocality_level_3 = geocoded[key].value;
                            break;
                        case 'sublocality_level_4':
                            sublocality_level_4 = geocoded[key].value;
                            break;
                        case 'sublocality_level_5':
                            sublocality_level_5 = geocoded[key].value;
                            break;
                    }
                }
                if (lang === 'ja') {
                    street_address = ward + sublocality_level_1 + sublocality_level_2 + [sublocality_level_3, sublocality_level_4, sublocality_level_5].filter(Boolean).join('ー');
                } else {
                    street_address = [ward, sublocality_level_1, sublocality_level_2, [sublocality_level_3, sublocality_level_4, sublocality_level_5].filter(Boolean).join('-')].filter(Boolean).join(' ');
                }
                address.find('.sabai-googlemaps-address-street').val(street_address);
           } 
        }
    };
})(jQuery);
