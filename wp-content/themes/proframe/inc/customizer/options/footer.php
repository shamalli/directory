<?php
/**
 * Footer Customizer
 */

/**
 * Register the customizer.
 */
function proframe_footer_customize_register( $wp_customize ) {

	// Register new section: Footer
	$wp_customize->add_section( 'proframe_footer' , array(
		'title'    => esc_html__( 'Footer', 'proframe' ),
		'panel'    => 'proframe_options',
		'priority' => 21
	) );

	// Register footer background color setting
	$wp_customize->add_setting( 'proframe_footer_bg_color', array(
		'default'           => '#1e1e1e',
		'sanitize_callback' => 'proframe_sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'proframe_footer_bg_color', array(
		'label'             => esc_html__( 'Background color', 'proframe' ),
		'section'           => 'proframe_footer',
		'priority'          => 7
	) ) );

	// Register footer widget column setting
	$wp_customize->add_setting( 'proframe_footer_widget_column', array(
		'default'           => '4',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_footer_widget_column', array(
		'label'             => esc_html__( 'Footer Widget Columns', 'proframe' ),
		'section'           => 'proframe_footer',
		'priority'          => 9,
		'type'              => 'radio',
		'choices'           => array(
			'3' => esc_html__( '3 Columns', 'proframe' ),
			'4' => esc_html__( '4 Columns', 'proframe' )
		)
	) );

	// Register Footer Credits setting
	$wp_customize->add_setting( 'proframe_footer_credits', array(
		'sanitize_callback' => 'proframe_sanitize_html',
		'default'           => '&copy; Copyright ' . date( 'Y' ) . ' - <a href="' . esc_url( home_url() ) . '">' . esc_attr( get_bloginfo( 'name' ) ) . '</a>. All Rights Reserved. <br /> Designed & Developed by <a href="https://www.theme-junkie.com/">Theme Junkie</a>',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'proframe_footer_credits', array(
		'label'             => esc_html__( 'Footer Text', 'proframe' ),
		'section'           => 'proframe_footer',
		'priority'          => 11,
		'type'              => 'textarea'
	) );
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'proframe_footer_credits', array(
			'selector'         => '.copyright',
			'settings'         => array( 'proframe_footer_credits' ),
			'render_callback'  => function() {
				return proframe_sanitize_html( get_theme_mod( 'proframe_footer_credits' ) );
			}
		) );
	}

}
add_action( 'customize_register', 'proframe_footer_customize_register' );
