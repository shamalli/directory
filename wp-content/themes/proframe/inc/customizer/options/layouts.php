<?php
/**
 * Blog Layouts Customizer
 */

/**
 * Register the customizer.
 */
function proframe_blog_layouts_customize_register( $wp_customize ) {

	// Register new section: Blog Layouts
	$wp_customize->add_section( 'proframe_blog' , array(
		'title'           => esc_html__( 'Blog Layouts', 'proframe' ),
		'panel'           => 'proframe_options',
		'priority'        => 9,
		'active_callback' => 'is_home',
	) );

	// Register blog layouts setting
	$wp_customize->add_setting( 'proframe_blog_layouts', array(
		'default'           => 'right-sidebar',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_blog_layouts', array(
		'label'             => esc_html__( 'Blog Layout', 'proframe' ),
		'section'           => 'proframe_blog',
		'priority'          => 1,
		'type'              => 'radio',
		'choices'           => array(
			'right-sidebar' => esc_html__( 'Right sidebar', 'proframe' ),
			'left-sidebar'  => esc_html__( 'Left sidebar', 'proframe' ),
			'full-width'    => esc_html__( 'Full width', 'proframe' )
		),
	) );

	// Register blog types setting
	$wp_customize->add_setting( 'proframe_blog_types', array(
		'default'           => 'default',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_blog_types', array(
		'label'             => esc_html__( 'Blog Types', 'proframe' ),
		'section'           => 'proframe_blog',
		'priority'          => 3,
		'type'              => 'radio',
		'choices'           => array(
			'default'    => esc_html__( 'Default', 'proframe' ),
			'list'       => esc_html__( 'List', 'proframe' ),
			'alternate'  => esc_html__( 'Alternate', 'proframe' ),
			'grid'       => esc_html__( 'Grid', 'proframe' )
		),
	) );

}
add_action( 'customize_register', 'proframe_blog_layouts_customize_register' );
