<?php
// Return early if no widget found.
if ( ! is_active_sidebar( 'primary' ) ) {
	return;
}

// Hide on full-width layout ( single post and page )
if ( in_array( get_theme_mod( 'theme_layout' ), array( 'full-width', 'full-width-narrow' ) ) ) {
	return;
}

// Hide on full-width layout ( home page )
if ( is_home() ) {
	if (
		in_array( get_theme_mod( 'proframe_blog_layouts' ),
			array(
				'full-width',
				'full-width-narrow',
				'grid-three',
				'grid-four',
				'masonry-three',
				'masonry-four',
				'list-full-width',
				'list-full-width-narrow',
			)
		)
	) {
		return;
	}
}
?>

<div id="secondary" class="widget-area" aria-label="<?php echo esc_attr_x( 'Primary Sidebar', 'Sidebar aria label', 'proframe' ); ?>">
	<?php dynamic_sidebar( 'primary' ); ?>
</div><!-- #secondary -->
