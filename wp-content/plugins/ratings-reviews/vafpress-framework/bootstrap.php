<?php

if( defined('W2RR_VP_VERSION') )
	return;

//////////////////////////
// Include Constants    //
//////////////////////////
require_once 'constant.php';

//////////////////////////
// Include Autoloader   //
//////////////////////////
require_once 'autoload.php';


//////////////////////////
// Setup FileSystem     //
//////////////////////////
$vpfs = W2RR_VP_FileSystem::instance();
$vpfs->add_directories('views'   , W2RR_VP_VIEWS_DIR);
$vpfs->add_directories('config'  , W2RR_VP_CONFIG_DIR);
$vpfs->add_directories('data'    , W2RR_VP_DATA_DIR);
$vpfs->add_directories('includes', W2RR_VP_INCLUDE_DIR);

//////////////////////////
// Include Data Source  //
//////////////////////////
foreach (glob(W2RR_VP_DATA_DIR . "/*.php") as $datasource)
{
	require_once($datasource);
}

//////////////////////////
// TGMPA Unsetting      //
//////////////////////////
add_action('after_setup_theme', 'w2rr_vp_tgm_ac_check');

if( !function_exists('w2rr_vp_tgm_ac_check') )
{
	function w2rr_vp_tgm_ac_check()
	{
		add_action('tgmpa_register', 'w2rr_vp_tgm_ac_vafpress_check');	
	}
}

if( !function_exists('w2rr_vp_tgm_ac_vafpress_check') )
{
	function w2rr_vp_tgm_ac_vafpress_check()
	{
		if( defined('W2RR_VP_VERSION') and class_exists('TGM_Plugin_Activation') )
		{
			foreach (TGM_Plugin_Activation::$instance->plugins as $key => &$plugin)
			{
				if( $plugin['name'] === 'Vafpress Framework Plugin' )
				{
					unset(TGM_Plugin_Activation::$instance->plugins[$key]);
				}
			}
		}
	}
}

//////////////////////////
// Ajax Definition      //
//////////////////////////
add_action('wp_ajax_w2rr_vp_ajax_wrapper', 'w2rr_vp_ajax_wrapper');

if( !function_exists('w2rr_vp_ajax_wrapper') )
{
	function w2rr_vp_ajax_wrapper()
	{
		$function = sanitize_text_field($_POST['func']);
		$params   = $_POST['params'];

		if( W2RR_VP_Security::instance()->is_function_whitelisted($function) )
		{
			if(!is_array($params))
				$params = array($params);

			try {
				$result['data']    = call_user_func_array($function, $params);
				$result['status']  = true;
				$result['message'] = esc_html__("Successful", 'w2rr');
			} catch (Exception $e) {
				$result['data']    = '';
				$result['status']  = false;
				$result['message'] = $e->getMessage();		
			}
		}
		else
		{
			$result['data']    = '';
			$result['status']  = false;
			$result['message'] = esc_html__("Unauthorized function", 'w2rr');		
		}

		if (ob_get_length()) ob_clean();
		header('Content-type: application/json');
		echo json_encode($result);
		die();
	}
}

/////////////////////////////////
// Pool and Dependencies Init  //
/////////////////////////////////
add_action( 'init'                 , 'w2rr_vp_metabox_enqueue' );
add_action( 'current_screen'       , 'w2rr_vp_sg_enqueue' );
add_action( 'admin_enqueue_scripts', 'w2rr_vp_enqueue_scripts' );
add_action( 'current_screen'       , 'w2rr_vp_sg_init_buttons' );
add_filter( 'clean_url'            , 'w2rr_vp_ace_script_attributes', 10, 1 );

if( !function_exists('w2rr_vp_ace_script_attributes') )
{
	function w2rr_vp_ace_script_attributes( $url )
	{
		if ( FALSE === strpos( $url, 'ace.js' ) )
			return $url;

		return "$url' charset='utf8";
	}
}

if( !function_exists('w2rr_vp_metabox_enqueue') )
{
	function w2rr_vp_metabox_enqueue()
	{
		if( W2RR_VP_WP_Admin::is_post_or_page() and W2RR_VP_Metabox::pool_can_output() )
		{
			$loader = W2RR_VP_WP_Loader::instance();
			$loader->add_main_js( 'vp-metabox' );
			$loader->add_main_css( 'vp-metabox' );
		}
	}
}

if( !function_exists('w2rr_vp_sg_enqueue') )
{
	function w2rr_vp_sg_enqueue()
	{
		if( W2RR_VP_ShortcodeGenerator::pool_can_output() )
		{
			// enqueue dummy js
			$localize = W2RR_VP_ShortcodeGenerator::build_localize();
			wp_localize_script( 'vp-sg-dummy', 'w2rr_vp_sg', $localize );
			wp_enqueue_script( 'vp-sg-dummy' );

			$loader = W2RR_VP_WP_Loader::instance();
			$loader->add_main_js( 'vp-shortcode' );
			$loader->add_main_css( 'vp-shortcode' );
		}
	}
}

add_action('admin_footer', 'w2rr_vp_post_dummy_editor');

if( !function_exists('w2rr_vp_post_dummy_editor') )
{
	function w2rr_vp_post_dummy_editor()
	{
		/**
		 * If we're in post edit page, and the post type doesn't support `editor`
		 * we need to echo out a dummy editor to load all necessary js and css
		 * to be used in our own called wp editor.
		 */
		$loader = W2RR_VP_WP_Loader::instance();
		$types  = $loader->get_types();
		$dummy  = false;

		if( W2RR_VP_WP_Admin::is_post_or_page() )
		{
			$types = array_unique( array_merge( $types['metabox'], $types['shortcodegenerator'] ) );
			if( in_array('wpeditor', $types ) )
			{
				if( !W2RR_VP_ShortcodeGenerator::pool_supports_editor() and !W2RR_VP_Metabox::pool_supports_editor() )
					$dummy = true;
			}
		}
		else
		{
			$types = $types['option'];
			if( in_array('wpeditor', $types ) )
				$dummy = true;
		}

		if( $dummy )
		{
			echo '<div>';
			add_filter( 'wp_default_editor', 'w2rr_vp_return_default_editor_editor' );
			wp_editor ( '', 'w2rr_vp_dummy_editor' );
			echo '</div>';		
		}
	}
	
	function w2rr_vp_return_default_editor_editor()
	{
		return "tinymce";
	}
}

if( !function_exists('w2rr_vp_sg_init_buttons') )
{
	function w2rr_vp_sg_init_buttons()
	{
		if( W2RR_VP_ShortcodeGenerator::pool_can_output() )
		{
			W2RR_VP_ShortcodeGenerator::init_buttons();
		}
	}
}

if( !function_exists('w2rr_vp_enqueue_scripts') )
{
	function w2rr_vp_enqueue_scripts()
	{
		$loader = W2RR_VP_WP_Loader::instance();
		$loader->build();
	}
}

/**
 * Easy way to get metabox values using dot notation
 * example:
 * 
 * w2rr_vp_metabox('meta_name.field_name')
 * w2rr_vp_metabox('meta_name.group_name')
 * w2rr_vp_metabox('meta_name.group_name.0.field_name')
 * 
 */

if( !function_exists('w2rr_vp_metabox') )
{
	function w2rr_vp_metabox($key, $default = null, $post_id = null)
	{
		global $post;

		$w2rr_vp_metaboxes = W2RR_VP_Metabox::get_pool();

		if(!is_null($post_id))
		{
			$the_post = get_post($post_id);
			if ( empty($the_post) ) $post_id = null;
		}
			
		if(is_null($post) and is_null($post_id))
			return $default;

		$keys = explode('.', $key);
		$temp = NULL;

		foreach ($keys as $idx => $key)
		{
			if($idx == 0)
			{
				if(array_key_exists($key, $w2rr_vp_metaboxes))
				{
					$temp = $w2rr_vp_metaboxes[$key];
					if(!is_null($post_id))
						$temp->the_meta($post_id);
					else
						$temp->the_meta();
				}
				else
				{
					return $default;
				}
			}
			else
			{
				if(is_object($temp) and get_class($temp) === 'W2RR_VP_Metabox')
				{
					$temp = $temp->get_the_value($key);
				}
				else
				{
					if(is_array($temp) and array_key_exists($key, $temp))
					{
						$temp = $temp[$key];
					}
					else
					{
						return $default;
					}
				}
			}
		}
		return $temp;
	}
}

/**
 * Easy way to get option values using dot notation
 * example:
 * 
 * w2rr_vp_option('option_key.field_name')
 * 
 */

if( !function_exists('w2rr_vp_option') )
{
	function w2rr_vp_option($key, $default = null)
	{
		$w2rr_vp_options = W2RR_VP_Option::get_pool();

		if(empty($w2rr_vp_options))
			return $default;

		$keys = explode('.', $key);
		$temp = NULL;

		foreach ($keys as $idx => $key)
		{
			if($idx == 0)
			{
				if(array_key_exists($key, $w2rr_vp_options))
				{
					$temp = $w2rr_vp_options[$key];
					$temp = $temp->get_options();
				}
				else
				{
					return $default;
				}
			}
			else
			{
				if(is_array($temp) and array_key_exists($key, $temp))
				{
					$temp = $temp[$key];
				}
				else
				{
					return $default;
				}
			}
		}
		return $temp;
	}
}

/**
 * EOF
 */