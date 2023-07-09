<?php
/**
 * Fonts Customizer
 */

/**
 * Register the customizer.
 */
function proframe_fonts_customize_register( $wp_customize ) {

	// Register new section: Fonts
	$wp_customize->add_section( 'proframe_fonts' , array(
		'title'       => esc_html__( 'Fonts', 'proframe' ),
		'description' => sprintf( __( 'These options is used for customizing the fonts. Please <a href="%s" target="_blank">read the documentation</a> if you don&quot;t understand how to use it.', 'proframe' ), 'https://www.theme-junkie.com/documentation/proframe/#typography' ),
		'panel'       => 'proframe_options',
		'priority'    => 5
	) );

	// Register heading custom text.
	$wp_customize->add_setting( 'proframe_heading_font_title', array(
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( new Proframe_Custom_Title_Control( $wp_customize, 'proframe_heading_font_title', array(
		'label'             => esc_html__( 'Heading', 'proframe' ),
		'section'           => 'proframe_fonts',
		'priority'          => 2
	) ) );

	// Register heading font setting.
	$wp_customize->add_setting( 'proframe_heading_font', array(
		'default'           => 'Montserrat:400,400i,600,600i,900',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'proframe_heading_font', array(
		'description'       => esc_html__( 'Font name/style/sets', 'proframe' ),
		'section'           => 'proframe_fonts',
		'priority'          => 3,
		'type'              => 'text'
	) );

	// Register heading font family setting.
	$wp_customize->add_setting( 'proframe_heading_font_family', array(
		'default'           => '\'Montserrat\', sans-serif',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'proframe_heading_font_family', array(
		'description'       => esc_html__( 'Font family', 'proframe' ),
		'section'           => 'proframe_fonts',
		'priority'          => 4,
		'type'              => 'text'
	) );

	// Register heading custom text.
	$wp_customize->add_setting( 'proframe_body_font_title', array(
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( new Proframe_Custom_Title_Control( $wp_customize, 'proframe_body_font_title', array(
		'label'             => esc_html__( 'Body', 'proframe' ),
		'section'           => 'proframe_fonts',
		'priority'          => 5
	) ) );

	// Register body font setting.
	$wp_customize->add_setting( 'proframe_body_font', array(
		'default'           => 'Montserrat:400,400i,600,600i,900',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'proframe_body_font', array(
		'description'       => esc_html__( 'Font name/style/sets', 'proframe' ),
		'section'           => 'proframe_fonts',
		'priority'          => 6,
		'type'              => 'text'
	) );

	// Register body font family setting.
	$wp_customize->add_setting( 'proframe_body_font_family', array(
		'default'           => '\'Montserrat\', sans-serif',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'proframe_body_font_family', array(
		'description'       => esc_html__( 'Font family', 'proframe' ),
		'section'           => 'proframe_fonts',
		'priority'          => 7,
		'type'              => 'text'
	) );

}
add_action( 'customize_register', 'proframe_fonts_customize_register' );
