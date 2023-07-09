(function($){
    SABAI.GoogleMaps = SABAI.GoogleMaps || {};
    SABAI.GoogleMaps.autocomplete = SABAI.GoogleMaps.autocomplete || function (input, options) {
        if (typeof google === 'undefined' || !google.maps.places) return;

        var $input = $(input);
        if (!$input.length) return;
        options = options || {};
        options.types = ['geocode'];
        if (options.country) {
            options.componentRestrictions = options.componentRestrictions || {};
            options.componentRestrictions.country = options.country;
        }
        $input.each(function(){
            var ele = $(this).get(0);
            google.maps.event.addDomListener(ele, 'focus', function(e) {
                var autocomplete = new google.maps.places.Autocomplete(ele, options);
                if (options.markerMap) {
                    autocomplete.addListener('place_changed', function() {
                        $(options.markerMap).find('.sabai-googlemaps-find-on-map').click();
                    });
                }
            });
            google.maps.event.addDomListener(ele, 'keydown', function(e) { 
                if (e.keyCode == 13) { 
                    e.preventDefault();
                }
            });
        });
    }
})(jQuery);
