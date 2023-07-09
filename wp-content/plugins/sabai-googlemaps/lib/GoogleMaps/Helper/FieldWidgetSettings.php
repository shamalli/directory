<?php
class Sabai_Addon_GoogleMaps_Helper_FieldWidgetSettings extends Sabai_Helper
{
    public function help(Sabai $application, array $settings, $weight = 0)
    {
        return array(
            'latlng_required_if_address' => array(
                '#type' => 'checkbox',
                '#title' => __('Require a location on map if the address field is not empty', 'sabai-googlemaps'),
                '#default_value' => !empty($settings['latlng_required_if_address']),
                '#states' => array(
                    'invisible' => array(
                        'input[name="required[]"]' => array('type' => 'checked', 'value' => true),
                    ),
                ),
                '#weight' => ++$weight,
            ),
            'map_type' => array(
                '#type' => 'select',
                '#title' => __('Map type', 'sabai-googlemaps'),
                '#options' => $application->GoogleMaps_Types(),
                '#default_value' => $settings['map_type'],
                '#weight' => ++$weight,
            ),
            'map_height' => array(
                '#type' => 'textfield',
                '#size' => 4,
                '#maxlength' => 3,
                '#field_suffix' => 'px',
                '#title' => __('Map height', 'sabai-googlemaps'),
                '#description' => __('Enter the height of map in pixels.', 'sabai-googlemaps'),
                '#default_value' => $settings['map_height'],
                '#numeric' => true,
                '#weight' => ++$weight,
            ),
            'center_latitude' => array(
                '#type' => 'textfield',
                '#size' => 15,
                '#maxlength' => 9,
                '#title' => __('Default latitude', 'sabai-googlemaps'),
                '#description' => __('Enter the latitude of the default map location in decimals.', 'sabai-googlemaps'),
                '#default_value' => $settings['center_latitude'],
                '#regex' => '/^-?([1-8]?[1-9]|[1-9]?0)\.{1}\d{1,5}/',
                '#numeric' => true,
                '#weight' => ++$weight,
            ),
            'center_longitude' => array(
                '#type' => 'textfield',
                '#size' => 15,
                '#maxlength' => 10,
                '#title' => __('Default longitude', 'sabai-googlemaps'),
                '#description' => __('Enter the longitude of the default map location in decimals.', 'sabai-googlemaps'),
                '#default_value' => $settings['center_longitude'],
                '#regex' => '/^-?((([1]?[0-7][0-9]|[1-9]?[0-9])\.{1}\d{1,6}$)|[1]?[1-8][0]\.{1}0{1,6}$)/',
                '#numeric' => true,
                '#weight' => ++$weight,
            ),
            'zoom' => array(
                '#type' => 'textfield',
                '#size' => 3,
                '#maxlength' => 2,
                '#title' => __('Default zoom level', 'sabai-googlemaps'),
                '#default_value' => $settings['zoom'],
                '#integer' => true,
                '#min_value' => 0,
                '#weight' => ++$weight,
            ),
        );
    }
}