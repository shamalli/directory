<?php
/*
Plugin Name: Sabai Paid Listings
Plugin URI: http://codecanyon.net/user/onokazu/portfolio?ref=onokazu
Description: Paid Listings add-on for Sabai plugins.
Author: onokazu
Author URI: http://codecanyon.net/user/onokazu/portfolio?ref=onokazu
Text Domain: sabai-paidlistings
Domain Path: /languages
Version: 1.3.29
Sabai License Package: sabai-directory
*/
define('SABAI_PACKAGE_PAIDLISTINGS_PATH', dirname(__FILE__));

function sabai_wordpress_paidlistings_addon_path($paths)
{
    $paths[] = array(SABAI_PACKAGE_PAIDLISTINGS_PATH . '/lib', '1.3.29');
    return $paths;
}
add_filter('sabai_sabai_addon_paths', 'sabai_wordpress_paidlistings_addon_path');

if (is_admin()) {
    function sabai_wordpress_paidlistings_activation_hook()
    {
        if (!function_exists('get_sabai_platform')) die('The Sabai plugin needs to be activated first before activating this plugin!');
        get_sabai_platform()->activatePlugin('sabai-paidlistings', array('PaidListings' => array(), 'ManualPayment' => array(), 'PayPal' => array()));
    }
    register_activation_hook(__FILE__, 'sabai_wordpress_paidlistings_activation_hook');
}
