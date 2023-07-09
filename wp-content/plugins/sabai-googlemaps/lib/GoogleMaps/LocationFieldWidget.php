<?php
class Sabai_Addon_GoogleMaps_LocationFieldWidget extends Sabai_Addon_Field_Widget_AbstractWidget
{
    protected function _fieldWidgetGetInfo()
    {
        return array(
            'label' => __('Google Map', 'sabai-googlemaps'),
            'field_types' => array('googlemaps_marker'),
            'default_settings' => array(
                'latlng_required_if_address' => true,
                'map_type' => 'roadmap',
                'map_height' => 300,
                'center_latitude' => 40.69847,
                'center_longitude' => -73.95144,
                'zoom' => 10,
                'autocomplete_country' => null,
            ),
            'repeatable' => array('group_fields' => false),
            'requirable' => true,
        );
    }

    public function fieldWidgetGetSettingsForm($fieldType, array $settings, array $parents = array())
    {
        $ret = $this->_addon->getApplication()->GoogleMaps_FieldWidgetSettings($settings);
        $ret['autocomplete_country'] = array('#weight' => 30) + $this->_addon->getApplication()->GoogleMaps_AutocompleteCountryFormField($settings['autocomplete_country']);
        return $ret;
    }

    public function fieldWidgetGetForm(Sabai_Addon_Field_IField $field, array $settings, Sabai_Addon_Entity_Model_Bundle $bundle, $value = null, Sabai_Addon_Entity_IEntity $entity = null, array $parents = array(), $admin = false)
    {
        return array(
            '#type' => 'googlemaps_marker',
            '#map_type' => $settings['map_type'],
            '#map_height' => $settings['map_height'],
            '#center_latitude' => $settings['center_latitude'],
            '#center_longitude' => $settings['center_longitude'],
            '#zoom' => $settings['zoom'],
            '#default_value' => $value,
            '#latlng_required_if_address' => !empty($settings['latlng_required_if_address']),
            '#autocomplete_country' => $settings['autocomplete_country'],
        );
    }
    
    public function fieldWidgetGetPreview(Sabai_Addon_Field_IField $field, array $settings)
    {
        $marker = $styles = array();
        $marker[] = $settings['center_latitude'] . ',' . $settings['center_longitude'];
        return sprintf(
            '<div><input type="text" disabled="disabled" style="width:100%%;" /></div><div><img src="http://maps.googleapis.com/maps/api/staticmap?center=%1$f,%2$f&zoom=%3$d&size=600x%4$d&sensor=false&markers=%5$s&maptype=%6$s" style="width:100%%;" /></div>',
            $settings['center_latitude'],
            $settings['center_longitude'],
            $settings['zoom'],
            $settings['map_height'],
            rawurlencode(implode('|', $marker)),
            $settings['map_type']
        );
    }

    public function fieldWidgetGetEditDefaultValueForm($fieldType, array $settings, array $parents = array()){}
}