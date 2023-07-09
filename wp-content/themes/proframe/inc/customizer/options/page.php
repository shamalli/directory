<?php
/**
 * Page Customizer
 */

/**
 * Register the customizer.
 */
function proframe_page_customize_register( $wp_customize ) {

	// Register new section: Page
	$wp_customize->add_section( 'proframe_page' , array(
		'title'       => esc_html__( 'Pages', 'proframe' ),
		'description' => esc_html__( 'These options are for customizing the page.', 'proframe' ),
		'panel'       => 'proframe_options',
		'priority'    => 17
	) );

	// Register page layouts setting
	$wp_customize->add_setting( 'proframe_page_layouts', array(
		'default'           => 'right-sidebar',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_page_layouts', array(
		'label'             => esc_html__( 'Page Layout', 'proframe' ),
		'description'       => esc_html__( 'This setting will change all pages layout.', 'proframe' ),
		'section'           => 'proframe_page',
		'priority'          => 1,
		'type'              => 'radio',
		'choices'           => array(
			'right-sidebar'     => esc_html__( 'Right sidebar', 'proframe' ),
			'left-sidebar'      => esc_html__( 'Left sidebar', 'proframe' ),
			'full-width'        => esc_html__( 'Full width', 'proframe' ),
			'full-width-narrow' => esc_html__( 'Full width narrow', 'proframe' ),
		),
	) );

	// Register page thumbnail setting
	$wp_customize->add_setting( 'proframe_page_thumbnail', array(
		'default'           => 0,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_page_thumbnail', array(
		'label'             => esc_html__( 'Show page thumbnail', 'proframe' ),
		'section'           => 'proframe_page',
		'priority'          => 3,
		'type'              => 'checkbox',
	) );

	// Register Page title setting
	$wp_customize->add_setting( 'proframe_page_title', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_page_title', array(
		'label'             => esc_html__( 'Enable page title', 'proframe' ),
		'section'           => 'proframe_page',
		'priority'          => 5,
		'type'              => 'checkbox'
	) );

	// Register page comment manager setting
	$wp_customize->add_setting( 'proframe_page_comment', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_page_comment', array(
		'label'             => esc_html__( 'Enable comment on Pages', 'proframe' ),
		'section'           => 'proframe_page',
		'priority'          => 7,
		'type'              => 'checkbox',
	) );

}
add_action( 'customize_register', 'proframe_page_customize_register' );
