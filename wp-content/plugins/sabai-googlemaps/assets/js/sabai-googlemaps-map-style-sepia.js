(function($){
    SABAI.GoogleMaps.styles = [
        {
            'featureType': 'water',
            'elementType': 'all',
            'stylers': [{'hue': '#ff9100'}, {'lightness': 52}]
        },
        {
            'featureType': 'water',
            'elementType': 'labels',
            'stylers': [{'visibility': 'off'}]
        },
        {
            'featureType': 'road',
            'elementType': 'labels',
            'stylers': [{'visibility': 'off'}]
        },
        {
            'featureType': 'road.highway',
            'elementType': 'geometry',
            'stylers': [{'saturation': -100}]
        },
        {
            'featureType': 'road.arterial',
            'elementType': 'geometry',
            'stylers': [{'saturation': -100}]
        },
        {
            'featureType': 'road.local',
            'elementType': 'geometry',
            'stylers': [{'lightness': -27}]
        },
        {
            'featureType': 'landscape',
            'elementType': 'all',
            'stylers': [{'hue': '#ffa200'}, {'lightness': -20}, {'visibility': 'off'}]
        },
        {
            'featureType': 'administrative',
            'elementType': 'labels',
            'stylers': [{'hue': '#1100ff'}, {'saturation': -100}, {'lightness': -18}]
        },
        {
            'featureType': 'administrative',
            'elementType': 'geometry',
            'stylers': [{'visibility': 'simplified'}]
        },
        {
            'featureType': 'transit',
            'elementType': 'all',
            'stylers': [{'visibility': 'off'}]
        },
        {
            'featureType': 'poi',
            'stylers': [
                {'visibility': 'off'}
            ]   
        }
    ];
})(jQuery);

