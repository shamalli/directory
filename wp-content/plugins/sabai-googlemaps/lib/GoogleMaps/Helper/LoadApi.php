<?php
class Sabai_Addon_GoogleMaps_Helper_LoadApi extends Sabai_Helper
{
    static protected $_apiLoaded;

    /**
     * Loads GoogleMaps API
     * @param Sabai $application
     */
    public function help(Sabai $application, array $options = array())
    {
        if (!self::$_apiLoaded) {        
            self::$_apiLoaded = true;
            if (!$application->getAddon('GoogleMaps')->getConfig('api', $application->getPlatform()->isAdmin() ? 'no_admin' : 'no')) {
                $application->LoadJs('//maps.googleapis.com/maps/api/js?libraries=places&language=' . $application->GoogleMaps_Language(), 'sabai-googlemaps', null, false);
            }
        }   
        if (!empty($options['map'])) {
            $application->LoadJs('infobox.min.js', 'sabai-googlemaps-infobox', 'sabai', 'sabai-googlemaps');
            $application->LoadJs('sabai-googlemaps-map.min.js', 'sabai-googlemaps-map', 'sabai', 'sabai-googlemaps');
        }
        if (!empty($options['style'])) {
            $application->LoadJs($application->GoogleMaps_Style($options['style'], true), 'sabai-googlemaps-style', 'sabai-googlemaps-map', false);
        } 
        if (!empty($options['autocomplete'])) {
            $application->LoadJs('sabai-googlemaps-autocomplete.min.js', 'sabai-googlemaps-autocomplete', 'sabai', 'sabai-googlemaps');
        }
        if (!empty($options['markermap'])) {
            $application->LoadJs('sabai-googlemaps-markermap.min.js', 'sabai-googlemaps-markermap', 'sabai', 'sabai-googlemaps');
            $application->LoadJs('jquery.fitmaps.min.js', 'jquery-fitmaps', 'jquery', 'sabai-googlemaps');
        }
        if (!empty($options['markerclusterer'])) {        
            $application->LoadJs('markerclusterer.min.js', 'sabai-googlemaps-markerclusterer', 'sabai', 'sabai-googlemaps');
        }
    }
}
