<?php

return array(

	////////////////////////////////////////
	// Localized JS Message Configuration //
	////////////////////////////////////////

	/**
	 * Validation Messages
	 */
	'validation' => array(
		'alphabet'     => esc_html__('Value needs to be Alphabet', 'w2rr'),
		'alphanumeric' => esc_html__('Value needs to be Alphanumeric', 'w2rr'),
		'numeric'      => esc_html__('Value needs to be Numeric', 'w2rr'),
		'email'        => esc_html__('Value needs to be Valid Email', 'w2rr'),
		'url'          => esc_html__('Value needs to be Valid URL', 'w2rr'),
		'maxlength'    => esc_html__('Length needs to be less than {0} characters', 'w2rr'),
		'minlength'    => esc_html__('Length needs to be more than {0} characters', 'w2rr'),
		'maxselected'  => esc_html__('Select no more than {0} items', 'w2rr'),
		'minselected'  => esc_html__('Select at least {0} items', 'w2rr'),
		'required'     => esc_html__('This is required', 'w2rr'),
	),

	/**
	 * Import / Export Messages
	 */
	'util' => array(
		'import_success'    => esc_html__('Import succeed, option page will be refreshed..', 'w2rr'),
		'import_failed'     => esc_html__('Import failed', 'w2rr'),
		'export_success'    => esc_html__('Export succeed, copy the JSON formatted options', 'w2rr'),
		'export_failed'     => esc_html__('Export failed', 'w2rr'),
		'restore_success'   => esc_html__('Restoration succeed, option page will be refreshed..', 'w2rr'),
		'restore_nochanges' => esc_html__('Options identical to default', 'w2rr'),
		'restore_failed'    => esc_html__('Restoration failed', 'w2rr'),
	),

	/**
	 * Control Fields String
	 */
	'control' => array(
		// select2vp select box
		'select2vp_placeholder' => esc_html__('Select option(s)', 'w2rr'),
		// fontawesome chooser
		'fac_placeholder'     => esc_html__('Select an Icon', 'w2rr'),
	),

);

/**
 * EOF
 */