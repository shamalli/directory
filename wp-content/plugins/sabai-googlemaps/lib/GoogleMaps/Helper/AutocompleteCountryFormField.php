<?php
class Sabai_Addon_GoogleMaps_Helper_AutocompleteCountryFormField extends Sabai_Helper
{
    public function help(Sabai $application, $value = null)
    {
        return array(
            '#title' => __('Country code', 'sabai-googlemaps'),
            '#description' => __('Enter one of the <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2" target="_blank">two-letter country codes</a> to restrict location autocomplete suggestions to a specific country.', 'sabai-googlemaps'),
            '#type' => 'textfield',
            '#size' => 3,
            '#default_value' => $value,
            '#min_length' => 2,
            '#max_length' => 2,
        );
    }
}