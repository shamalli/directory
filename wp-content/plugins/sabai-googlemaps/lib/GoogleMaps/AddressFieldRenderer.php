<?php
class Sabai_Addon_GoogleMaps_AddressFieldRenderer extends Sabai_Addon_Field_Renderer_AbstractRenderer
{    
    protected function _fieldRendererGetInfo()
    {
        return array(
            'field_types' => array('googlemaps_marker'),
            'default_settings' => array(
                'icon' => 'map-marker',
                'separator' => '<br />',
                'custom_format' => false,
                'format' => '%street%, %city%, %state% %zip%, %country%',
                'link' => false,
            ),
        );
    }
    
    public function fieldRendererGetSettingsForm($fieldType, array $settings, $view, array $parents = array())
    {
        return array(
            'icon' => array(
                '#type' => 'icon',
                '#title' => __('Icon', 'sabai-googlemaps'),
                '#default_value' => $settings['icon'],
            ),
            'custom_format' => array(
                '#type' => 'checkbox',
                '#title' => __('Customize the format of address', 'sabai-googlemaps'),
                '#default_value' => !empty($settings['custom_format']),
            ),
            'format' => array(
                '#type' => 'textfield',
                '#title' => __('Custom format', 'sabai-googlemaps'),
                '#default_value' => $settings['format'],
                '#states' => array(
                    'visible' => array(
                        sprintf('input[name="%s[custom_format][]"]', $this->_addon->getApplication()->Form_FieldName($parents)) => array('type' => 'checked', 'value' => true),
                    ),
                ),
                '#required' => create_function('$form', sprintf('$val = $form->getValue(array(\'%s\', \'custom_format\')); return !empty($val);', implode("', '", $parents))),
            ),
            'link' => array(
                '#type' => 'checkbox',
                '#title' => __('Link to Google Maps or native map application', 'sabai-googlemaps'),
                '#default_value' => !empty($settings['link']),
            ),
        );
    }

    public function fieldRendererRenderField(Sabai_Addon_Field_IField $field, array $settings, array $values, Sabai_Addon_Entity_IEntity $entity)
    {
        $ret = array();
        $icon = $settings['icon'] ? '<i class="fa fa-' . Sabai::h($settings['icon']) . ' fa-fw"></i> ' : '';
        foreach ($values as $key => $value) {
            if ($settings['custom_format']) {
                $replace = array(
                    '%street%' => Sabai::h($value['street']),
                    '%city%' => Sabai::h($value['city']),
                    '%state%' => Sabai::h($value['state']),
                    '%zip%' => Sabai::h($value['zip']),
                    '%country%' => Sabai::h($value['country']),
                );
                $formatted = strtr($settings['format'], $replace);
            } else {
                $formatted = Sabai::h($value['address']);
            }
            if ($settings['link']) {
                $formatted = sprintf('<a href="http://maps.apple.com/?q=%s,%s">%s</a>', $value['lat'], $value['lng'], $formatted);
            }
            $ret[] = sprintf('<span class="sabai-googlemaps-address sabai-googlemaps-address-%d">%s%s</span>', $key, $icon, $formatted);
        }
        return implode($settings['separator'], $ret);
    }
}
