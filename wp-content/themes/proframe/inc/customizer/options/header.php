<?php
/**
 * Header Customizer
 */

/**
 * Register the customizer.
 */
function proframe_header_customize_register( $wp_customize ) {

	// Register new section: Header
	$wp_customize->add_section( 'proframe_header' , array(
		'title'           => esc_html__( 'Header', 'proframe' ),
		'panel'           => 'proframe_options',
		'priority'        => 7
	) );

	// Register search icon setting
	$wp_customize->add_setting( 'proframe_search_icon', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_search_icon', array(
		'label'             => esc_html__( 'Enable search icon', 'proframe' ),
		'section'           => 'proframe_header',
		'priority'          => 1,
		'type'              => 'checkbox'
	) );

	// Register header layout setting
	$wp_customize->add_setting( 'proframe_header_layout', array(
		'default'           => 'default',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_header_layout', array(
		'label'             => esc_html__( 'Layout', 'proframe' ),
		'section'           => 'proframe_header',
		'priority'          => 3,
		'type'              => 'radio',
		'choices'           => array(
			'default'   => esc_html__( 'Default', 'proframe' ),
			'fullwidth' => esc_html__( 'Full Width', 'proframe' )
		)
	) );

}
add_action( 'customize_register', 'proframe_header_customize_register' );
