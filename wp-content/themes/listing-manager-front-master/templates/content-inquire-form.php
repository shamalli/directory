<?php if ( has_term( 'listing', 'product_type' ) ) : ?>
	<div class="inquire-form-wrapper">
	    <h2><?php echo esc_html__( 'Contact Listing Owner', 'listing-manager-front' ); ?></h2>
	    <?php echo do_shortcode( '[listing_manager_inquire]' ); ?>
	</div><!-- /.inquire-form -->
<?php endif; ?>
