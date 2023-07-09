<?php
/**
 * General Customizer
 */

/**
 * Register the customizer.
 */
function proframe_general_customize_register( $wp_customize ) {

	// Register new section: General
	$wp_customize->add_section( 'proframe_general' , array(
		'title'    => esc_html__( 'General', 'proframe' ),
		'panel'    => 'proframe_options',
		'priority' => 1
	) );

	// Register container setting
	$wp_customize->add_setting( 'proframe_container_style', array(
		'default'           => 'fullwidth',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_container_style', array(
		'label'             => esc_html__( 'Container', 'proframe' ),
		'section'           => 'proframe_general',
		'priority'          => 1,
		'type'              => 'radio',
		'choices'           => array(
			'fullwidth' => esc_html__( 'Full Width', 'proframe' ),
			'boxed'     => esc_html__( 'Boxed', 'proframe' ),
			'framed'    => esc_html__( 'Framed', 'proframe' )
		)
	) );

	// Register pagination setting
	$wp_customize->add_setting( 'proframe_posts_pagination', array(
		'default'           => 'traditional',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_posts_pagination', array(
		'label'             => esc_html__( 'Pagination type', 'proframe' ),
		'description'       => esc_html__( 'For blog, archive & search page.', 'proframe' ),
		'section'           => 'proframe_general',
		'priority'          => 3,
		'type'              => 'radio',
		'choices'           => array(
			'number'      => esc_html__( 'Number', 'proframe' ),
			'traditional' => esc_html__( 'Older / Newer', 'proframe' ),
			'load_more'   => esc_html__( 'Load More', 'proframe' ),
		)
	) );

	// Register sticky sidebar setting
	$wp_customize->add_setting( 'proframe_sticky_sidebar', array(
		'default'           => 0,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_sticky_sidebar', array(
		'label'             => esc_html__( 'Enable sticky sidebar', 'proframe' ),
		'section'           => 'proframe_general',
		'priority'          => 5,
		'type'              => 'checkbox'
	) );

	// Register back to top setting
	$wp_customize->add_setting( 'proframe_back_to_top', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_back_to_top', array(
		'label'             => esc_html__( 'Enable back to top button', 'proframe' ),
		'section'           => 'proframe_general',
		'priority'          => 7,
		'type'              => 'checkbox'
	) );

	// Register custom RSS setting
	$wp_customize->add_setting( 'proframe_custom_rss', array(
		'default'           => '',
		'sanitize_callback' => 'proframe_sanitize_url',
	) );
	$wp_customize->add_control( 'proframe_custom_rss', array(
		'label'             => esc_html__( 'Custom RSS', 'proframe' ),
		'description'       => esc_html__( 'Replace the default WordPress RSS URL.', 'proframe' ),
		'section'           => 'proframe_general',
		'priority'          => 9,
		'type'              => 'url'
	) );

}
add_action( 'customize_register', 'proframe_general_customize_register' );
