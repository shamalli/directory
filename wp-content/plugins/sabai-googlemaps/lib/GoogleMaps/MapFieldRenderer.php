<?php
class Sabai_Addon_GoogleMaps_MapFieldRenderer extends Sabai_Addon_Field_Renderer_AbstractRenderer
{
    protected function _fieldRendererGetInfo()
    {
        return array(
            'label' => __('Map renderer', 'sabai-googlemaps'),
            'field_types' => array('googlemaps_marker'),
            'default_settings' => array(
                'type' => 'map',
                'zoom' => 15,
                'scrollwheel' => false,
                'height' => 300,
                'directions' => true,
            ),
            'separatable' => false,
        );
    }
    
    public function fieldRendererGetSettingsForm($fieldType, array $settings, $view, array $parents = array())
    {
        return $this->_addon->getApplication()->GoogleMaps_MapOptions($settings);
    }

    public function fieldRendererRenderField(Sabai_Addon_Field_IField $field, array $settings, array $values, Sabai_Addon_Entity_IEntity $entity)
    {
        return $this->_addon->getApplication()->GoogleMaps_RenderMap($values, $settings);
    }
}