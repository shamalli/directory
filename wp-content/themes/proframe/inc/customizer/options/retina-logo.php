<?php
/**
 * Retina Logo Customizer
 */

/**
 * Register the customizer.
 */
function proframe_retina_logo_customize_register( $wp_customize ) {

	// Register footer branding setting
	$wp_customize->add_setting( 'proframe_retina_logo', array(
		'default'           => '',
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'proframe_retina_logo', array(
		'label'             => esc_html__( 'Retina Logo', 'proframe' ),
		'section'           => 'title_tagline',
		'priority'          => 9,
		'flex_width'        => true,
		'flex_height'       => true,
		'width'             => 500,
		'height'            => 100
	) ) );

}
add_action( 'customize_register', 'proframe_retina_logo_customize_register' );
