<?php
/**
 * Elementor compatibility and custom functions.
 */

namespace Elementor;

/**
 * Elementor setup function.
 *
 * @return void
 */
function proframe_update_elementor_global_option () {
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
	update_option( 'elementor_container_width', '1110' );
}
add_action( 'after_switch_theme', 'Elementor\proframe_update_elementor_global_option' );

/**
 * Add widgets
 */
function proframe_elementor_custom_widgets() {
	require_once get_template_directory() . '/inc/elementor/widgets/slides.php';
	require_once get_template_directory() . '/inc/elementor/widgets/portfolio.php';
}
add_action( 'elementor/widgets/widgets_registered', 'Elementor\proframe_elementor_custom_widgets' );

/**
 * Custom scripts
 */
function proframe_elementor_scripts() {
	wp_register_script( 'proframe-elementor', trailingslashit( get_template_directory_uri() ) . 'inc/elementor/js/elementor-widgets.js', [ 'jquery' ], false, true );
	wp_register_script( 'proframe-owl', trailingslashit( get_template_directory_uri() ) . 'assets/js/devs/owl.carousel.js', [ 'jquery' ], false, true );
}
add_action( 'elementor/frontend/after_register_scripts', 'Elementor\proframe_elementor_scripts' );
