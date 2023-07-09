<?php
/**
 * TGM Plugin Lists
 */

// Include the TGM_Plugin_Activation class.
require trailingslashit( get_template_directory() ) . 'inc/extensions/tgmpa.php';

/**
 * Register required and recommended plugins.
 */
function proframe_register_plugins() {

	$plugins = array(

		array(
			'name'     => 'MailOptin',
			'slug'     => 'mailoptin',
			'required' => false,
		),

		array(
			'name'     => 'One Click Demo Import',
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),

		array(
			'name'     => 'Elementor',
			'slug'     => 'elementor',
			'required' => false,
		),

		array(
			'name'     => 'Junkie Portfolio',
			'slug'     => 'theme-junkie-portfolio-content',
			'required' => false,
		),

		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),

	);

	$config = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'proframe_register_plugins' );
