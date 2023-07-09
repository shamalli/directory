<?php
// Return early if no widget found.
if ( ! is_active_sidebar( 'portfolio' ) ) {
	return;
}

// Hide on full-width layout ( single post and page )
if ( in_array( get_theme_mod( 'theme_layout' ), array( 'full-width', 'full-width-narrow' ) ) ) {
	return;
}
?>

<div id="portfolio-sidebar" class="widget-area" aria-label="<?php echo esc_attr_x( 'Portfolio Sidebar', 'Sidebar aria label', 'proframe' ); ?>">
	<?php dynamic_sidebar( 'portfolio' ); ?>
</div><!-- #portfolio-sidebar -->
