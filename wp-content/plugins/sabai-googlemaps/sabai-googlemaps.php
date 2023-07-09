<?php
/*
Plugin Name: Sabai Google Maps
Plugin URI: http://codecanyon.net/user/onokazu/portfolio?ref=onokazu
Description: Google Maps add-on for Sabai plugins.
Author: onokazu
Author URI: http://codecanyon.net/user/onokazu/portfolio?ref=onokazu
Text Domain: sabai-googlemaps
Domain Path: /languages
Version: 1.3.29
Sabai License Package: sabai-directory
*/
define('SABAI_PACKAGE_GOOGLEMAPS_PATH', dirname(__FILE__));

function sabai_wordpress_googlemaps_init()
{
    load_plugin_textdomain('sabai-googlemaps', false, 'sabai-googlemaps/languages/');
}
add_action('init', 'sabai_wordpress_googlemaps_init');

function sabai_wordpress_googlemaps_addon_path($paths)
{
    $paths[] = array(SABAI_PACKAGE_GOOGLEMAPS_PATH . '/lib', '1.3.29');
    return $paths;
}
add_filter('sabai_sabai_addon_paths', 'sabai_wordpress_googlemaps_addon_path');

if (is_admin()) {
    function sabai_wordpress_googlemaps_activation_hook()
    {
        if (!function_exists('get_sabai_platform')) die('The Sabai plugin needs to be activated first before activating this plugin!');
        get_sabai_platform()->activatePlugin('sabai-googlemaps', array('GoogleMaps' => array()));
    }
    register_activation_hook(__FILE__, 'sabai_wordpress_googlemaps_activation_hook');
}
