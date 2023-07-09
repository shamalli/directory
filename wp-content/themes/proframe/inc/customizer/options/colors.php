<?php
/**
 * Colors Customizer
 */

/**
 * Register the customizer.
 */
function proframe_colors_customize_register( $wp_customize ) {

	// Register predefined colors setting
	$wp_customize->add_setting( 'proframe_predefined_colors', array(
		'default'           => 'default',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_predefined_colors', array(
		'label'             => esc_html__( 'Skins', 'proframe' ),
		'section'           => 'colors',
		'priority'          => 1,
		'type'              => 'radio',
		'choices'           => array(
			'default' => esc_html__( 'Default', 'proframe' ),
			'black'   => esc_html__( 'Black', 'proframe' ),
		)
	) );

}
add_action( 'customize_register', 'proframe_colors_customize_register' );
