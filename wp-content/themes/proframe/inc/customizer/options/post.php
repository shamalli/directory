<?php
/**
 * Post Customizer
 */

/**
 * Register the customizer.
 */
function proframe_post_customize_register( $wp_customize ) {

	// Register new section: Post
	$wp_customize->add_section( 'proframe_post' , array(
		'title'       => esc_html__( 'Posts', 'proframe' ),
		'description' => esc_html__( 'These options are for customizing the single post.', 'proframe' ),
		'panel'       => 'proframe_options',
		'priority'    => 15
	) );

	// Register post layouts setting
	$wp_customize->add_setting( 'proframe_post_layouts', array(
		'default'           => 'right-sidebar',
		'sanitize_callback' => 'proframe_sanitize_select',
	) );
	$wp_customize->add_control( 'proframe_post_layouts', array(
		'label'             => esc_html__( 'Post Layout', 'proframe' ),
		'description'       => esc_html__( 'This setting will change all posts layout.', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 1,
		'type'              => 'radio',
		'choices'           => array(
			'right-sidebar'     => esc_html__( 'Right sidebar', 'proframe' ),
			'left-sidebar'      => esc_html__( 'Left sidebar', 'proframe' ),
			'full-width'        => esc_html__( 'Full width', 'proframe' ),
			'full-width-narrow' => esc_html__( 'Full width narrow', 'proframe' ),
		),
	) );

	// Register post tags setting
	$wp_customize->add_setting( 'proframe_post_tags', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_post_tags', array(
		'label'             => esc_html__( 'Enable tags', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 3,
		'type'              => 'checkbox'
	) );

	// Register post tags title setting
	$wp_customize->add_setting( 'proframe_post_tags_title', array(
		'default'           => esc_html__( 'Topics', 'proframe' ),
		'sanitize_callback' => 'proframe_sanitize_html',
		'transport'         => 'postMessage'
	) );
	$wp_customize->add_control( 'proframe_post_tags_title', array(
		'label'             => esc_html__( 'Post tags title', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 5,
		'type'              => 'text',
		'active_callback'   => 'proframe_is_post_tags_checked'
	) );
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'proframe_post_tags_title', array(
			'selector'         => '.tag-title',
			'settings'         => array( 'proframe_post_tags_title' ),
			'render_callback'  => function() {
				return proframe_sanitize_html( get_theme_mod( 'proframe_post_tags_title' ) );
			}
		) );
	}

	// Register Author Box setting
	$wp_customize->add_setting( 'proframe_author_box', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_author_box', array(
		'label'             => esc_html__( 'Enable author box', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 7,
		'type'              => 'checkbox'
	) );

	// Register Next & Prev post setting
	$wp_customize->add_setting( 'proframe_next_prev_post', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_next_prev_post', array(
		'label'             => esc_html__( 'Enable next & prev post', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 9,
		'type'              => 'checkbox'
	) );

	// Register Related Posts setting
	$wp_customize->add_setting( 'proframe_related_posts', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_related_posts', array(
		'label'             => esc_html__( 'Enable related posts', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 13,
		'type'              => 'checkbox'
	) );

	// Register Related posts title setting
	$wp_customize->add_setting( 'proframe_related_posts_title', array(
		'default'           => esc_html__( 'You Might Also Like', 'proframe' ),
		'sanitize_callback' => 'proframe_sanitize_html',
		'transport'         => 'postMessage'
	) );
	$wp_customize->add_control( 'proframe_related_posts_title', array(
		'label'             => esc_html__( 'Related posts title', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 15,
		'type'              => 'text',
		'active_callback'   => 'proframe_is_related_posts_checked'
	) );
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'proframe_related_posts_title', array(
			'selector'         => '.related-title',
			'settings'         => array( 'proframe_related_posts_title' ),
			'render_callback'  => function() {
				return proframe_sanitize_html( get_theme_mod( 'proframe_related_posts_title' ) );
			}
		) );
	}

	// Register Related posts title setting
	$wp_customize->add_setting( 'proframe_related_posts_number', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'proframe_related_posts_number', array(
		'label'             => esc_html__( 'Related posts number', 'proframe' ),
		'description'       => esc_html__( 'The number of posts you want to show.', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 17,
		'type'              => 'number',
		'input_attrs'       => array(
			'min'  => 0,
			'step' => 1
		),
		'active_callback'   => 'proframe_is_related_posts_checked'
	) );

	// Register Post comment manager setting
	$wp_customize->add_setting( 'proframe_post_comment', array(
		'default'           => 1,
		'sanitize_callback' => 'proframe_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'proframe_post_comment', array(
		'label'             => esc_html__( 'Enable comment on post', 'proframe' ),
		'section'           => 'proframe_post',
		'priority'          => 19,
		'type'              => 'checkbox'
	) );

}
add_action( 'customize_register', 'proframe_post_customize_register' );

/**
 * Active callback when Post Tags checked.
 */
function proframe_is_post_tags_checked() {
	$tags = get_theme_mod( 'proframe_post_tags', 1 );

	if ( $tags ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Active callback when Related Posts checked.
 */
function proframe_is_related_posts_checked() {
	$related = get_theme_mod( 'proframe_related_posts', 1 );

	if ( $related ) {
		return true;
	} else {
		return false;
	}
}
