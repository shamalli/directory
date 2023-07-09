		<?php do_action( 'listing_manager_front_after_main' ); ?>

		<?php if ( is_active_sidebar( 'footer-left') || is_active_sidebar( 'footer-right' ) ) : ?>
			<div class="footer-wrapper">
				<div class="footer">
					<div class="footer-inner">
						<?php if ( is_active_sidebar( 'footer-left') ) : ?>
							<div class="footer-left">
								<?php dynamic_sidebar( 'footer-left' ); ?>
							</div><!-- /.footer-left -->
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'footer-right') ) : ?>
							<div class="footer-right">
								<?php dynamic_sidebar( 'footer-right' ); ?>
							</div><!-- /.footer-right -->
						<?php endif; ?>
					</div><!-- /.footer-inner -->
				</div><!-- /.footer -->
			</div><!-- /.footer-wrapper -->
		<?php endif; ?>
	</div><!-- /.site-wrapper -->

	<?php wp_footer(); ?>
</body>
</html>