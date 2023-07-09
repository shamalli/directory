		</div><!-- #content -->

		<footer id="colophon" class="site-footer">

			<?php if ( has_nav_menu ( 'social' ) ) : ?>
				<div class="social-links">
					<div class="container">

						<?php wp_nav_menu(
							array(
								'theme_location'  => 'social',
								'link_before'     => '<span class="social-name">',
								'link_after'      => '</span>',
								'depth'           => 1,
								'container'       => '',
							)
						); ?>

					</div>
				</div>
			<?php endif; ?>

			<div class="site-bottom">
				<div class="container">

					<?php get_template_part( 'sidebar', 'footer' ); // Loads the sidebar-footer.php template. ?>

					<div class="copyrights">

						<div class="site-info">
							<?php proframe_footer_text(); ?>
						</div><!-- .site-info -->

						<?php if ( has_nav_menu ( 'footer' ) ) : ?>
							<nav class="footer-navigation">
								<?php wp_nav_menu(
									array(
										'theme_location'  => 'footer',
										'menu_id'         => 'menu-footer-items',
										'menu_class'      => 'menu-footer-items',
										'container'       => false,
										'depth'           => 1
									)
								); ?>
							</nav>
						<?php endif; ?>

					</div>

				</div>
			</div>

		</footer><!-- #colophon -->

	</div><!-- .wide-container -->

</div><!-- #page -->

<div id="search-overlay" class="search-popup popup-content mfp-hide">
	<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="search-field field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'proframe' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'proframe' ) ?>" />
	</form>
</div>

<?php proframe_back_to_top(); ?>

<?php wp_footer(); ?>

</body>
</html>
