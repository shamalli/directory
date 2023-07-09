<?php
class Sabai_Addon_GoogleMaps_MapFormField extends Sabai_Addon_Form_Field_Group
{
    private static $_rendererAdded = false;

    public function formFieldGetFormElement($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        $map = $attr = array();
        if (!empty($data['#default_value']['lat']) && !empty($data['#default_value']['lng'])) {
            $map['center-lat'] = $map['lat'] = str_replace(',', '.', floatval($data['#default_value']['lat']));
            $map['center-lng'] = $map['lng'] = str_replace(',', '.', floatval($data['#default_value']['lng']));
        } else {
            $map['center-lng'] = str_replace(',', '.', isset($data['#center_longitude']) ? floatval($data['#center_longitude']) : -73.95144);
            $map['center-lat'] = str_replace(',', '.', isset($data['#center_latitude']) ? floatval($data['#center_latitude']) : 40.69847);
            $map['lat'] = $map['lng'] = '';
        }
        if (!empty($data['#default_value']['zoom'])) {
            $map['zoom'] = $data['#default_value']['zoom'];
        } else {
            $map['zoom'] = isset($data['#zoom']) ? intval($data['#zoom']) : 10;
        }
        $map['map-type'] = isset($data['#map_type']) && in_array(strtolower($data['#map_type']), array('satellite', 'hybrid', 'osm'))
            ? $data['#map_type']
            : 'roadmap';
        if (!empty($data['#marker_icon'])) {
            $map['icon'] = $data['#marker_icon'];
        }
        foreach ($map as $key => $value) {
            $attr[$key] = sprintf('data-%s="%s"', $key, Sabai::h($value));
        }
        $data = array(
            '#tree' => true,
            '#children' => array(
                0 => array(),
            ),
        ) + $data + $form->defaultElementSettings();
        $data['#children'][0] += array(
            'prefix' => array(
                '#type' => 'markup',
                '#markup' => sprintf('<div class="sabai-googlemaps-map" %s>', implode(' ', $attr)),
            ) + $form->defaultElementSettings(),
            'map' => array(
                '#type' => 'markup',
                '#markup' => sprintf('<div style="height:%dpx;" class="sabai-googlemaps-map-map"></div>', empty($data['#map_height']) ? 300 : $data['#map_height']),
            ) + $form->defaultElementSettings(),
            'manual' => array(
                '#type' => 'checkbox',
                '#title' => __('Enter coordinates manually', 'sabai-googlemaps'),
                '#attributes' => array('class' => 'sabai-googlemaps-map-manual', 'style' => 'margin-top:3px;'),
            ) + $form->defaultElementSettings(),
            'lat' => array(
                '#type' => 'textfield',
                '#default_value' => @$data['#default_value']['lat'],
                '#attributes' => array('class' => 'sabai-googlemaps-map-lat'),
                '#numeric' => true,
                '#title' => __('Latitude', 'sabai-googlemaps'),
                '#class' => 'sabai-googlemaps-map-lat-container',
                '#states' => array(
                    'visible' => array('.sabai-googlemaps-map-manual' => array('type' => 'checked', 'value' => true, 'container' => '.sabai-form-type-googlemaps-map')),
                ),
                '#states_selector' => '.sabai-googlemaps-map-lat-container',
                '#required' => !empty($data['#required']),
            ) + $form->defaultElementSettings(),
            'lng' => array(
                '#type' => 'textfield',
                '#default_value' => @$data['#default_value']['lng'],
                '#attributes' => array('class' => 'sabai-googlemaps-map-lng'),
                '#numeric' => true,
                '#title' => __('Longitude', 'sabai-googlemaps'),
                '#class' => 'sabai-googlemaps-map-lng-container',
                '#states' => array(
                    'visible' => array('.sabai-googlemaps-map-manual' => array('type' => 'checked', 'value' => true, 'container' => '.sabai-form-type-googlemaps-map')),
                ),
                '#states_selector' => '.sabai-googlemaps-map-lng-container',
                '#required' => !empty($data['#required']),
            ) + $form->defaultElementSettings(),
            'zoom' => array(
                '#type' => 'markup',
                '#value' => sprintf('<input type="hidden" name="%s[zoom]" value="%d" class="sabai-googlemaps-map-zoom" />', Sabai::h($name), isset($data['#default_value']['zoom']) ? $data['#default_value']['zoom'] : 10),
            ) + $form->defaultElementSettings(),
            'suffix' => array(
                '#type' => 'markup',
                '#markup' => '</div>',
            ) + $form->defaultElementSettings(),
        );
        
        $data['#class'] .= ' sabai-form-group';
     
        // Register pre render callback if this is the first map element
        if (!self::$_rendererAdded) {
            $form->settings['#pre_render'][] = array($this, 'preRenderCallback');
            self::$_rendererAdded = true;
        }

        return $form->createFieldset($name, $data);
    }

    public function formFieldOnSubmitForm($name, &$value, array &$data, Sabai_Addon_Form_Form $form)
    {
        parent::formFieldOnSubmitForm($name, $value, $data, $form);
        
        if ($form->isFieldRequired($data)) {
            if (empty($value['lat']) || empty($value['lng'])) {
                $form->setError(__('Please select a valid location on map.', 'sabai-googlemaps'), $name . '[map]');
            }
        }
    }

    public function preRenderCallback($form)
    {
        $application = $this->_addon->getApplication();
        $application->GoogleMaps_LoadApi(array('markermap' => true));
        
        $form->addJs('jQuery(document).ready(function($){
    jQuery(".sabai-form-type-googlemaps-map").each(function(index){
        var field = jQuery(this);
        SABAI.GoogleMaps.markerMap(field, "' . $application->GoogleMaps_Language() . '", index === 0);
    });
});');
    }
}
