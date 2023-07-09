<?php
class Sabai_Addon_GoogleMaps_Helper_Types extends Sabai_Helper
{
    public function help(Sabai $application)
    {
        return array(
            'roadmap' => __('Google (roadmap)', 'sabai-googlemaps'),
            'satellite' => __('Google (satellite)', 'sabai-googlemaps'),
            'hybrid' => __('Google (hybrid)', 'sabai-googlemaps'),
            'osm' => __('OpenStreetMap', 'sabai-googlemaps'),
        );
    }
}