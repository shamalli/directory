<?php
class Sabai_Addon_GoogleMaps extends Sabai_Addon
    implements Sabai_Addon_Form_IFields,
               Sabai_Addon_Field_ITypes,
               Sabai_Addon_Field_IWidgets,
               Sabai_Addon_Field_IRenderers,
               Sabai_Addon_Field_IFilters,
               Sabai_Addon_System_IAdminSettings
{
    const VERSION = '1.3.29', PACKAGE = 'sabai-googlemaps';
    
    private static $_doneHead = false;

    public function formGetFieldTypes()
    {
        return array('googlemaps_marker', 'googlemaps_map');
    }

    public function formGetField($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/LocationFormField.php';
                return new Sabai_Addon_GoogleMaps_LocationFormField($this, $name);
            case 'googlemaps_map':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/MapFormField.php';
                return new Sabai_Addon_GoogleMaps_MapFormField($this, $name);
        }
    }

    public function fieldGetTypeNames()
    {
        return array('googlemaps_marker');
    }

    public function fieldGetType($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/LocationFieldType.php';
                return new Sabai_Addon_GoogleMaps_LocationFieldType($this, $name);
        }
    }
    
    public function fieldGetFilterNames()
    {
        return array('googlemaps_marker');
    }

    public function fieldGetFilter($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/LocationFieldFilter.php';
                return new Sabai_Addon_GoogleMaps_LocationFieldFilter($this, $name);
        }
    }
    
    public function fieldGetRendererNames()
    {
        return array('googlemaps_marker', 'googlemaps_map');
    }

    public function fieldGetRenderer($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/AddressFieldRenderer.php';
                return new Sabai_Addon_GoogleMaps_AddressFieldRenderer($this, $name);
            case 'googlemaps_map':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/MapFieldRenderer.php';
                return new Sabai_Addon_GoogleMaps_MapFieldRenderer($this, $name);
        }
    }

    public function fieldGetWidgetNames()
    {
        return array('googlemaps_marker');
    }

    public function fieldGetWidget($name)
    {
        switch ($name) {
            case 'googlemaps_marker':
                require_once SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib/GoogleMaps/LocationFieldWidget.php';
                return new Sabai_Addon_GoogleMaps_LocationFieldWidget($this, $name);
        }
    }
    
    public function onSabaiWebResponseRenderHtmlLayout(Sabai_Context $context, &$content)
    { 
        if (self::$_doneHead) return;
        
        // The main stylesheet should already have been included by the platform if not requesting the full page content
        if ($context->getContainer() !== '#sabai-content') return;

        $this->_application->LoadCss(
            $this->_application->getPlatform()->isAdmin() ? 'admin.min.css' : 'main.min.css',
            'sabai-googlemaps',
            'sabai',
            'sabai-googlemaps'
        );
        
        self::$_doneHead = true;
    }
    
    public function getDefaultConfig()
    {
        return array(
            'api' => array('type' => 'free'),
        );
    }
    
    public function systemGetAdminSettingsForm()
    {
        return array(
            'api' => array(
                '#tree' => true,
                'no' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Do not load Google Maps API', 'sabai-googlemaps'),
                    '#default_value' => !empty($this->_config['api']['no'])
                ),
                'no_admin' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Do not load Google Maps API in admin dashboard', 'sabai-googlemaps'),
                    '#default_value' => !empty($this->_config['api']['no_admin'])
                ),
                'type' => array(
                    '#title' => __('Google Maps API type', 'sabai-googlemaps'),
                    '#type' => 'radios',
                    '#options' => array('free' => __('Google Maps API (free)', 'sabai-googlemaps'), 'business' =>  __('Google Maps API for Business', 'sabai-googlemaps')),
                    '#default_value' => isset($this->_config['api']['type']) ? $this->_config['api']['type'] : 'free',
                ),
                'key' => array(
                    '#type' => 'textfield',
                    '#title' => __('Google Geocoding API key', 'sabai-googlemaps'),
                    '#description' => sprintf(__('The API key for the Google Geocoding service can be obtained from the following URL: %s', 'sabai-googlemaps'), 'https://developers.google.com/maps/documentation/geocoding/#api_key'),
                    '#default_value' => isset($this->_config['api']['key']) ? $this->_config['api']['key'] : (defined('SABAI_GOOGLEMAPS_GEOCODING_APIKEY') ? SABAI_GOOGLEMAPS_GEOCODING_APIKEY : null),
                    '#states' => array(
                        'visible' => array(
                            'input[name="api[type]"]' => array('value' => 'free'),
                        ),
                    ),
                ),
                'client_id' => array(
                    '#type' => 'textfield',
                    '#title' => __('Google Maps API for Work client ID', 'sabai-googlemaps'),
                    '#default_value' => @$this->_config['api']['client_id'],
                    '#states' => array(
                        'visible' => array(
                            'input[name="api[type]"]' => array('value' => 'business'),
                        ),
                    ),
                    '#required' => array(array($this, 'isSettingFieldRequired'), array('business')),
                    '#description' => sprintf(__('Enter the cliend ID provided by Google. Also add the following code to any line in wp-config.php: %s', 'sabai-googlemaps'), "<code>define('SABAI_GOOGLEMAPS_API_PRIVATE_KEY', 'Put your private key provided by Google here');</code>"),
                ),
            ),
        );
    }
    
    public function isSettingFieldRequired($form, $type)
    {
        return empty($form->values['api']['no']) && $form->values['api']['type'] === $type;
    }
}