<?php
class Sabai_Addon_GoogleMaps_Helper_MapOptions extends Sabai_Helper
{
    public function help(Sabai $application, array $values, $checkbox = false)
    {
        $values += array(
            'type' => 'roadmap',
            'style' => '',
            'zoom' => 15,
            'scrollwheel' => false,
            'height' => 300,
            'directions' => true,
            'infobox_width' => 200,
        );
        return array(
            'type' => array(
                '#type' => 'select',
                '#title' => __('Default map type', 'sabai-googlemaps'),
                '#options' => $application->GoogleMaps_Types(),
                '#default_value' => $values['type'],
            ),
            'style' => array(
                '#type' => 'select',
                '#options' => array('' => __('Default style', 'sabai-googlemaps')) + $application->GoogleMaps_Style(),
                '#title' => __('Google map style', 'sabai-googlemaps'),
                '#default_value' => $values['style'],
            ),
            'zoom' => array(
                '#type' => 'select',
                '#title' => __('Default zoom level', 'sabai-googlemaps'),
                '#options' => array_combine(range(0, 19), range(0, 19)),
                '#default_value' => $values['zoom'],
            ),
            'height' => array(
                '#type' => 'number',
                '#size' => 4,
                '#integer' => true,
                '#field_suffix' => 'px',
                '#min_value' => 1,
                '#default_value' => $values['height'],
                '#title' => __('Map height', 'sabai-googlemaps'),
            ),
            'scrollwheel' => array(
                '#type' => $checkbox ? 'checkbox' : 'yesno',
                '#default_value' => !empty($values['scrollwheel']),
                '#title' => __('Enable scrollwheel zooming', 'sabai-googlemaps'),
            ),
            'directions' => array(
                '#type' => $checkbox ? 'checkbox' : 'yesno',
                '#default_value' => !empty($values['directions']),
                '#title' => __('Enable directions search', 'sabai-googlemaps'),
            ),
            'infobox_width' => array(
                '#type' => 'number',
                '#size' => 4,
                '#integer' => true,
                '#field_suffix' => 'px',
                '#min_value' => 1,
                '#default_value' => $values['infobox_width'],
                '#title' => __('Map infobox width', 'sabai-googlemaps'),
            ),
        );
    }
}