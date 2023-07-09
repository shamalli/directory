<?php
class Sabai_Addon_GoogleMaps_LocationFormField extends Sabai_Addon_Form_Field_Group
{
    private static $_rendererAdded = false;

    public function formFieldGetFormElement($name, array &$data, Sabai_Addon_Form_Form $form)
    {
        $map = $attr = array();
        if (!empty($data['#default_value']['lat']) && !empty($data['#default_value']['lng'])) {
            $map['center-lat'] = $map['lat'] = str_replace(',', '.', floatval($data['#default_value']['lat']));
            $map['center-lng'] = $map['lng'] = str_replace(',', '.', floatval($data['#default_value']['lng']));
        } else {
            if (isset($data['#center_longitude'])) {
                $map['center-lng'] = str_replace(',', '.', floatval($data['#center_longitude']));
            }
            if (isset($data['#center_latitude'])) {
                $map['center-lat'] = str_replace(',', '.', floatval($data['#center_latitude']));
            }
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
            'address' => array(
                '#type' => 'textfield',
                '#attributes' => array('class' => 'sabai-googlemaps-formatted-address', 'data-autocomplete-country' => (string)@$data['#autocomplete_country']),
                '#default_value' => @$data['#default_value']['address'],
                '#required' => !empty($data['#required']),
            ) + (array)@$data['#address'] + $form->defaultElementSettings(),
            'buttons' => array(
                '#type' => 'markup',
                '#markup' => '<div style="margin:0 0 5px;">
    <a class="sabai-btn sabai-btn-info sabai-btn-xs sabai-googlemaps-find-on-map" href="#"><i class="fa fa-search"></i> ' . __('Find on map', 'sabai-googlemaps') . '</a>
    <a class="sabai-btn sabai-btn-info sabai-btn-xs sabai-googlemaps-get-from-map" href="#"><i class="fa fa-arrow-up"></i> ' . __('Get from map', 'sabai-googlemaps') . '</a>
</div>',
            ) + $form->defaultElementSettings(),
            'separator' => array(
                '#type' => 'markup',
                '#markup' => sprintf('<div class="sabai-googlemaps-map" %s>', implode(' ', $attr)),
            ) + $form->defaultElementSettings(),
            'map' => array(
                '#type' => 'markup',
                '#markup' => sprintf('<div style="height:%dpx;" class="sabai-googlemaps-map-map"></div>', empty($data['#map_height']) ? 300 : $data['#map_height']),
            ) + $form->defaultElementSettings(),
            'manual' => array(
                '#type' => 'checkbox',
                '#title' => __('Enter address details manually', 'sabai-googlemaps'),
                '#attributes' => array('class' => 'sabai-googlemaps-map-manual'),
            ) + $form->defaultElementSettings(),
            '_address' => array(
                '#type' => 'address',
                '#disable_street2' => true,
                '#class' => 'sabai-googlemaps-address',
                '#class_street' => 'sabai-googlemaps-address-street',
                '#class_city' => 'sabai-googlemaps-address-city',
                '#class_province' => 'sabai-googlemaps-address-province',
                '#class_zip' => 'sabai-googlemaps-address-zip',
                '#class_country' => 'sabai-googlemaps-address-country',
                '#default_value' => is_array(@$data['#default_value']['_address']) ? $data['#default_value']['_address'] : $data['#default_value'],
                '#states' => array(
                    'visible' => array('.sabai-googlemaps-map-manual' => array('type' => 'checked', 'value' => true, 'container' => '.sabai-form-type-googlemaps-marker')),
                ),
                '#country_type' => 'Countries',
            ) + $form->defaultElementSettings(),
            'lat' => array(
                '#type' => 'textfield',
                '#default_value' => @$data['#default_value']['lat'],
                '#attributes' => array('class' => 'sabai-googlemaps-map-lat'),
                '#numeric' => true,
                '#description' => __('Latitude', 'sabai-googlemaps'),
                '#class' => 'sabai-col-sm-6 sabai-googlemaps-map-lat-container',
                '#states' => array(
                    'visible' => array('.sabai-googlemaps-map-manual' => array('type' => 'checked', 'value' => true, 'container' => '.sabai-form-type-googlemaps-marker')),
                ),
                '#states_selector' => '.sabai-googlemaps-map-lat-container',
                '#required' => !empty($data['#required']),
                '#prefix' => '<div class="sabai-row">',
            ) + $form->defaultElementSettings(),
            'lng' => array(
                '#type' => 'textfield',
                '#default_value' => @$data['#default_value']['lng'],
                '#attributes' => array('class' => 'sabai-googlemaps-map-lng'),
                '#numeric' => true,
                '#description' => __('Longitude', 'sabai-googlemaps'),
                '#class' => 'sabai-col-sm-6 sabai-googlemaps-map-lng-container',
                '#states' => array(
                    'visible' => array('.sabai-googlemaps-map-manual' => array('type' => 'checked', 'value' => true, 'container' => '.sabai-form-type-googlemaps-marker')),
                ),
                '#states_selector' => '.sabai-googlemaps-map-lng-container',
                '#required' => !empty($data['#required']),
                '#suffix' => '</div>',
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
        $data['#latlng_required'] = $data['#required'];
        unset($data['#required']);
     
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
        
        if (empty($value['lat']) || empty($value['lng'])) {
            if ($data['#latlng_required']) {
                $form->setError(__('Please select a valid location on map.', 'sabai-googlemaps'), $name . '[map]');
            } elseif ($data['#latlng_required_if_address']) {
                if (strlen(trim($value['address']))) {
                    $form->setError(__('Please select a valid location on map.', 'sabai-googlemaps'), $name . '[map]');
                }
            }
        }
        
        if ($form->hasError()) return;
        
        if (!empty($value['_address'])) {
            foreach ($value['_address'] as $key => $_value) {
                $value[$key] = $_value;
            }
        } else {
            unset($value['_address']); // prevent from saving array as string
        }
    }

    public function preRenderCallback($form)
    {
        $application = $this->_addon->getApplication();
        $application->GoogleMaps_LoadApi(array('markermap' => true, 'autocomplete' => true));  
        
        $form->settings['#js'][] = 'jQuery(document).ready(function($){
    var googlemaps = function (field, cloneable) {
        SABAI.GoogleMaps.markerMap(field, "' . $application->GoogleMaps_Language() . '", cloneable);
        var address = field.find(".sabai-googlemaps-formatted-address");
        SABAI.GoogleMaps.autocomplete(address, {markerMap: field, country: address.data("autocomplete-country")});
    }
    $(".sabai-form-type-googlemaps-marker").each(function(index){
        var field = $(this);
        if (field.is(":visible")) {
            googlemaps(field, index === 0);
        } else {
            var tab = field.closest(".sabai-tab-pane");
            if (tab.length) {
                $("#" + tab.attr("id") + "-trigger").on("shown.bs.sabaitab", function(e, data){
                    googlemaps(field, index === 0);
                });
            }
        }
    });
});';
    }
}
