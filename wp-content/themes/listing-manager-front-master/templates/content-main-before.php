<?php if ( is_active_sidebar( 'main-top' ) ) : ?>
	<div class="main-top">
		<?php dynamic_sidebar( 'main-top' ); ?>
	</div><!-- /.content-top -->
<?php endif; ?>

<div class="main-wrapper">
	<div class="main">
		<?php if ( ! is_page_template( 'page-front-page.php') && class_exists( 'WooCommerce' ) ) : ?>
			<?php woocommerce_breadcrumb(); ?>
		<?php endif; ?>

		<?php if ( is_singular( 'product' ) ) : ?>
			<div class="woocommerce-product-actions">
				<?php do_action( 'listing_manager_front_product_actions' ); ?>
			</div><!-- /.woocommerce-product-actions -->
		<?php endif; ?>

		<div class="main-inner">
			<?php if ( ! is_page_template( 'page-front-page.php') ) : ?>
				<?php get_template_part( 'templates/content', 'page-title' ); ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'content-top' ) ) : ?>
				<div class="content-top">
					<?php dynamic_sidebar( 'content-top' ); ?>
				</div><!-- /.content-top -->
			<?php endif; ?>

			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<?php wc_print_notices(); ?>
			<?php endif; ?>
