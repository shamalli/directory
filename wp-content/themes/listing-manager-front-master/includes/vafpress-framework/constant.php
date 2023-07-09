<?php

/*
|--------------------------------------------------------------------------
| Vafpress Framework Constants
|--------------------------------------------------------------------------
*/

defined('VP_W2THEME_VERSION')     or define('VP_W2THEME_VERSION'    , '2.0-beta');
defined('VP_W2THEME_NAMESPACE')   or define('VP_W2THEME_NAMESPACE'  , 'VP_W2THEME_');
defined('VP_W2THEME_DIR')         or define('VP_W2THEME_DIR'        , untrailingslashit(dirname(__FILE__)));
defined('VP_W2THEME_DIR_NAME')    or define('VP_W2THEME_DIR_NAME'   , basename(VP_W2THEME_DIR));
defined('VP_W2THEME_IMAGE_DIR')   or define('VP_W2THEME_IMAGE_DIR'  , VP_W2THEME_DIR . '/public/img');
defined('VP_W2THEME_CONFIG_DIR')  or define('VP_W2THEME_CONFIG_DIR' , VP_W2THEME_DIR . '/config');
defined('VP_W2THEME_DATA_DIR')    or define('VP_W2THEME_DATA_DIR'   , VP_W2THEME_DIR . '/data');
defined('VP_W2THEME_CLASSES_DIR') or define('VP_W2THEME_CLASSES_DIR', VP_W2THEME_DIR . '/classes');
defined('VP_W2THEME_VIEWS_DIR')   or define('VP_W2THEME_VIEWS_DIR'  , VP_W2THEME_DIR . '/views');
defined('VP_W2THEME_INCLUDE_DIR') or define('VP_W2THEME_INCLUDE_DIR', VP_W2THEME_DIR . '/includes');

// finally framework base url
$vp_w2theme_url         = get_template_directory_uri() . '/includes/vafpress-framework';

defined('VP_W2THEME_URL')         or define('VP_W2THEME_URL'        , untrailingslashit($vp_w2theme_url));
defined('VP_W2THEME_PUBLIC_URL')  or define('VP_W2THEME_PUBLIC_URL' , VP_W2THEME_URL        . '/public');
defined('VP_W2THEME_IMAGE_URL')   or define('VP_W2THEME_IMAGE_URL'  , VP_W2THEME_PUBLIC_URL . '/img');
defined('VP_W2THEME_INCLUDE_URL') or define('VP_W2THEME_INCLUDE_URL', VP_W2THEME_URL        . '/includes');

// Get the start time and memory usage for profiling
defined('VP_W2THEME_START_TIME')  or define('VP_W2THEME_START_TIME', microtime(true));
defined('VP_W2THEME_START_MEM')   or define('VP_W2THEME_START_MEM',  memory_get_usage());

/**
 * EOF
 */