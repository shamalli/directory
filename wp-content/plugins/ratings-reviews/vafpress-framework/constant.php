<?php

/*
|--------------------------------------------------------------------------
| Vafpress Framework Constants
|--------------------------------------------------------------------------
*/

defined('VP_W2RR_VERSION')     or define('VP_W2RR_VERSION'    , '2.0-beta');
defined('VP_W2RR_NAMESPACE')   or define('VP_W2RR_NAMESPACE'  , 'VP_W2RR_');
defined('VP_W2RR_DIR')         or define('VP_W2RR_DIR'        , W2RR_PATH . 'vafpress-framework');
defined('VP_W2RR_DIR_NAME')    or define('VP_W2RR_DIR_NAME'   , basename(VP_W2RR_DIR));
defined('VP_W2RR_IMAGE_DIR')   or define('VP_W2RR_IMAGE_DIR'  , VP_W2RR_DIR . '/public/img');
defined('VP_W2RR_CONFIG_DIR')  or define('VP_W2RR_CONFIG_DIR' , VP_W2RR_DIR . '/config');
defined('VP_W2RR_DATA_DIR')    or define('VP_W2RR_DATA_DIR'   , VP_W2RR_DIR . '/data');
defined('VP_W2RR_CLASSES_DIR') or define('VP_W2RR_CLASSES_DIR', VP_W2RR_DIR . '/classes');
defined('VP_W2RR_VIEWS_DIR')   or define('VP_W2RR_VIEWS_DIR'  , VP_W2RR_DIR . '/views');
defined('VP_W2RR_INCLUDE_DIR') or define('VP_W2RR_INCLUDE_DIR', VP_W2RR_DIR . '/includes');

// finally framework base url
//$vp_w2rr_url         = trim(plugins_url('/', __FILE__), '/');

defined('VP_W2RR_URL')         or define('VP_W2RR_URL'        , W2RR_URL . 'vafpress-framework');
defined('VP_W2RR_PUBLIC_URL')  or define('VP_W2RR_PUBLIC_URL' , VP_W2RR_URL        . '/public');
defined('VP_W2RR_IMAGE_URL')   or define('VP_W2RR_IMAGE_URL'  , VP_W2RR_PUBLIC_URL . '/img');
defined('VP_W2RR_INCLUDE_URL') or define('VP_W2RR_INCLUDE_URL', VP_W2RR_URL        . '/includes');

// Get the start time and memory usage for profiling
defined('VP_W2RR_START_TIME')  or define('VP_W2RR_START_TIME', microtime(true));
defined('VP_W2RR_START_MEM')   or define('VP_W2RR_START_MEM',  memory_get_usage());

/**
 * EOF
 */