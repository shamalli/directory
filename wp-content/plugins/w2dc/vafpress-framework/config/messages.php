<?php

return array(

	////////////////////////////////////////
	// Localized JS Message Configuration //
	////////////////////////////////////////

	/**
	 * Validation Messages
	 */
	'validation' => array(
		'alphabet'     => esc_html__('Value needs to be Alphabet', 'w2dc'),
		'alphanumeric' => esc_html__('Value needs to be Alphanumeric', 'w2dc'),
		'numeric'      => esc_html__('Value needs to be Numeric', 'w2dc'),
		'email'        => esc_html__('Value needs to be Valid Email', 'w2dc'),
		'url'          => esc_html__('Value needs to be Valid URL', 'w2dc'),
		'maxlength'    => esc_html__('Length needs to be less than {0} characters', 'w2dc'),
		'minlength'    => esc_html__('Length needs to be more than {0} characters', 'w2dc'),
		'maxselected'  => esc_html__('Select no more than {0} items', 'w2dc'),
		'minselected'  => esc_html__('Select at least {0} items', 'w2dc'),
		'required'     => esc_html__('This is required', 'w2dc'),
	),

	/**
	 * Import / Export Messages
	 */
	'util' => array(
		'import_success'    => esc_html__('Import succeed, option page will be refreshed..', 'w2dc'),
		'import_failed'     => esc_html__('Import failed', 'w2dc'),
		'export_success'    => esc_html__('Export succeed, copy the JSON formatted options', 'w2dc'),
		'export_failed'     => esc_html__('Export failed', 'w2dc'),
		'restore_success'   => esc_html__('Restoration succeed, option page will be refreshed..', 'w2dc'),
		'restore_nochanges' => esc_html__('Options identical to default', 'w2dc'),
		'restore_failed'    => esc_html__('Restoration failed', 'w2dc'),
	),

	/**
	 * Control Fields String
	 */
	'control' => array(
		// select2vp select box
		'select2vp_placeholder' => esc_html__('Select option(s)', 'w2dc'),
		// fontawesome chooser
		'fac_placeholder'     => esc_html__('Select an Icon', 'w2dc'),
	),

);

/**
 * EOF
 */