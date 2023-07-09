<?php
/**
 * Portfolio Customizer
 */

/**
 * Register the customizer.
 */
function proframe_portfolio_customize_register( $wp_customize ) {

	// Register new section: Portfolio
	$wp_customize->add_section( 'proframe_portfolio' , array(
		'title'       => esc_html__( 'Portfolio', 'proframe' ),
		'panel'       => 'proframe_options',
		'priority'    => 19
	) );

	// Register portfolio title setting
	$wp_customize->add_setting( 'proframe_portfolio_title', array(
		'sanitize_callback' => 'proframe_sanitize_html',
		'default'           => esc_html__( 'Our Portfolio', 'proframe' ),
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'proframe_portfolio_title', array(
		'label'             => esc_html__( 'Title', 'proframe' ),
		'section'           => 'proframe_portfolio',
		'priority'          => 1,
		'type'              => 'text'
	) );
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'proframe_portfolio_title', array(
			'selector'         => '.post-type-archive-portfolio .archive-title',
			'settings'         => array( 'proframe_portfolio_title' ),
			'render_callback'  => function() {
				return proframe_sanitize_html( get_theme_mod( 'proframe_portfolio_title' ) );
			}
		) );
	}

	// Register number setting
	$wp_customize->add_setting( 'proframe_portfolio_number', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'proframe_portfolio_number', array(
		'label'             => esc_html__( 'Number of portfolio', 'proframe' ),
		'description'       => esc_html__( 'Number of portfolio to show in one page.', 'proframe' ),
		'section'           => 'proframe_portfolio',
		'priority'          => 3,
		'type'              => 'number',
		'input_attrs'       => array(
			'min'  => 0,
			'step' => 1
		)
	) );

	// Register portfolio layouts setting
	$wp_customize->add_setting( 'proframe_portfolio_layouts', array(
		'default'           => 'full-width',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_portfolio_layouts', array(
		'label'             => esc_html__( 'Layout', 'proframe' ),
		'section'           => 'proframe_portfolio',
		'priority'          => 5,
		'type'              => 'radio',
		'choices'           => array(
			'right-sidebar'     => esc_html__( 'Right sidebar', 'proframe' ),
			'left-sidebar'      => esc_html__( 'Left sidebar', 'proframe' ),
			'full-width'        => esc_html__( 'Full width', 'proframe' ),
			'full-width-narrow' => esc_html__( 'Full width narrow', 'proframe' ),
		),
	) );

	// Register portfolio columns setting
	$wp_customize->add_setting( 'proframe_portfolio_columns', array(
		'default'           => 'proframe-three-columns',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_portfolio_columns', array(
		'label'             => esc_html__( 'Columns', 'proframe' ),
		'section'           => 'proframe_portfolio',
		'priority'          => 7,
		'type'              => 'radio',
		'choices'           => array(
			'proframe-two-columns'   => esc_html__( 'Two columns', 'proframe' ),
			'proframe-three-columns' => esc_html__( 'Three columns', 'proframe' ),
			'proframe-four-columns'  => esc_html__( 'Four columns', 'proframe' ),
		),
	) );

}
add_action( 'customize_register', 'proframe_portfolio_customize_register' );
