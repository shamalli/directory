<?php
/*
Plugin Name: Sabai Directory
Plugin URI: http://codecanyon.net/user/onokazu/portfolio?ref=onokazu
Description: Business directory plugin for WordPress.
Author: onokazu
Author URI: http://codecanyon.net/user/onokazu/portfolio?ref=onokazu
Text Domain: sabai-directory
Domain Path: /languages
Version: 1.3.29
*/
define('SABAI_PACKAGE_DIRECTORY_PATH', dirname(__FILE__));

function sabai_wordpress_directory_init()
{
    include_once SABAI_PACKAGE_DIRECTORY_PATH . '/include/shortcodes.php';
}
add_action('init', 'sabai_wordpress_directory_init');

function sabai_wordpress_directory_addon_path($paths)
{
    $paths[] = array(SABAI_PACKAGE_DIRECTORY_PATH . '/lib', '1.3.29');
    return $paths;
}
add_filter('sabai_sabai_addon_paths', 'sabai_wordpress_directory_addon_path');

if (is_admin()) {
    function sabai_wordpress_directory_activation_hook()
    {
        if (!function_exists('get_sabai_platform')) die('The Sabai plugin needs to be activated first before activating this plugin!');
        get_sabai_platform()->activatePlugin('sabai-directory', array('Directory' => array(), 'DirectoryCSVImport' => array(), 'DirectoryBookmarks' => array()));
    }
    register_activation_hook(__FILE__, 'sabai_wordpress_directory_activation_hook');
    
    function sabai_wordpress_directory_plugin_row_meta($links, $file)
    {
        if ($file === plugin_basename(__FILE__)) {
            $links[] = '<a href="http://codecanyon.net/item/sabai-directory-plugin-for-wordpress/4505485/support" target="_blank">Support</a>';  
        }
        return $links; 
    } 
    add_filter('plugin_row_meta', 'sabai_wordpress_directory_plugin_row_meta', 10, 2);
}

function is_sabai_directory_listing()
{
    return isset($GLOBALS['sabai_entity'])
        && $GLOBALS['sabai_entity']->getBundleType() === 'directory_listing';
}

function is_sabai_directory_category($slug = null)
{
    if (!isset($GLOBALS['sabai_entity'])
        || $GLOBALS['sabai_entity']->getBundleType() !== 'directory_category'
    ) return false;
    
    return isset($slug) ? $GLOBALS['sabai_entity']->getSlug() === $slug : true;
}
