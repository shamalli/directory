<?php

/*
|--------------------------------------------------------------------------
| Vafpress Framework Constants
|--------------------------------------------------------------------------
*/

defined('W2RR_VP_VERSION')     or define('W2RR_VP_VERSION'    , '2.0-beta');
defined('W2RR_VP_NAMESPACE')   or define('W2RR_VP_NAMESPACE'  , 'W2RR_VP_');
defined('W2RR_VP_DIR')         or define('W2RR_VP_DIR'        , W2RR_PATH . 'vafpress-framework');
defined('W2RR_VP_DIR_NAME')    or define('W2RR_VP_DIR_NAME'   , basename(W2RR_VP_DIR));
defined('W2RR_VP_IMAGE_DIR')   or define('W2RR_VP_IMAGE_DIR'  , W2RR_VP_DIR . '/public/img');
defined('W2RR_VP_CONFIG_DIR')  or define('W2RR_VP_CONFIG_DIR' , W2RR_VP_DIR . '/config');
defined('W2RR_VP_DATA_DIR')    or define('W2RR_VP_DATA_DIR'   , W2RR_VP_DIR . '/data');
defined('W2RR_VP_CLASSES_DIR') or define('W2RR_VP_CLASSES_DIR', W2RR_VP_DIR . '/classes');
defined('W2RR_VP_VIEWS_DIR')   or define('W2RR_VP_VIEWS_DIR'  , W2RR_VP_DIR . '/views');
defined('W2RR_VP_INCLUDE_DIR') or define('W2RR_VP_INCLUDE_DIR', W2RR_VP_DIR . '/includes');

defined('W2RR_VP_URL')         or define('W2RR_VP_URL'        , W2RR_URL . 'vafpress-framework');
defined('W2RR_VP_PUBLIC_URL')  or define('W2RR_VP_PUBLIC_URL' , W2RR_VP_URL        . '/public');
defined('W2RR_VP_IMAGE_URL')   or define('W2RR_VP_IMAGE_URL'  , W2RR_VP_PUBLIC_URL . '/img');
defined('W2RR_VP_INCLUDE_URL') or define('W2RR_VP_INCLUDE_URL', W2RR_VP_URL        . '/includes');

// Get the start time and memory usage for profiling
defined('W2RR_VP_START_TIME')  or define('W2RR_VP_START_TIME', microtime(true));
defined('W2RR_VP_START_MEM')   or define('W2RR_VP_START_MEM',  memory_get_usage());

/**
 * EOF
 */