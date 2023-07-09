<!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="site-wrapper">
	<div class="header-wrapper">
			<div class="header">		

			<?php if (function_exists('w2dc_is_listing') && ($listing = w2dc_is_listing()) || (has_post_thumbnail())): ?>
			<?php
			if ($listing && $listing->logo_image)
				$image_url = $listing->get_logo_url();
			else
				$image_url = get_the_post_thumbnail_url(null, 'full');
			?>
			<div class="header-image" style="background-image: url('<?php echo $image_url; ?>');"></div>
			<?php endif; ?>		

			<div class="header-inner">
				<div class="header-content">
					<div class="site-branding">
						<div class="site-title">							
							<?php //the_custom_logo(); ?>
							
							<?php //if ( 'blank' !== get_theme_mod( 'header_textcolor', true ) ) : ?>
								<a href="<?php echo home_url( '/' ); ?>" class="site-name">
									<?php bloginfo( 'name' ); ?>
								</a>
							<?php //endif; ?>							
						</div><!-- /.site-title -->

						<?php //if ( 'blank' !== get_theme_mod( 'header_textcolor', true ) ) : ?>
							<div class="site-description">
								<?php echo html_entity_decode( get_bloginfo( 'description' ) ); ?>
							</div><!-- /.site-description -->
						<?php //endif; ?>
					</div><!-- /.site-branding -->

					<?php if ( is_user_logged_in() ) : ?>
						<div class="user-navigation">
							<div class="user-navigation-header">
								<?php $info = wp_get_current_user(); ?>

		                        <span class="user-navigation-avatar"
		                              style="background-image: url('<?php echo get_avatar_url(get_current_user_id() ); ?>');">
		                        </span><!-- /.navbar-user-avatar -->

	                            <span class="user-navigation-name">
	                                <?php echo esc_attr( $info->data->user_login ); ?>

	                                <i class="fa fa-chevron-down"></i>
	                            </span><!-- /.navbar-user-name -->
	                        </div><!-- /.user-navigation-header -->

	                        <?php if ( has_nav_menu( 'authenticated' ) ) : ?>
							<?php wp_nav_menu( array(
								'fallback_cb'       => '',
								'theme_location'    => 'authenticated',
							) ); ?>
							<?php endif; ?>
						</div><!-- /.user-navigation -->
					<?php endif; ?>

					<div class="site-navigation-toggle">
						<span></span>
						<span></span>
						<span></span>
					</div><!-- /.site-navigation-toggle -->
						
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<a href="<?php echo wc_get_cart_url(); ?>" class="site-cart">
							<i class="fa fa-shopping-cart"></i>
							<span class="badge">
								<?php echo esc_html( count( WC()->cart->cart_contents ) ); ?>
							</span>
						</a>
					<?php endif; ?>

					<?php if ( has_nav_menu( 'primary' ) ) : ?>
						<div class="site-navigation">
							<?php wp_nav_menu( array(
								'fallback_cb'       => '',
								'theme_location'    => 'primary',
							) ); ?>
						</div><!-- /.site-navigation -->
					<?php endif; ?>
				</div><!-- /.header-content -->

				<div class="header-sticky">
					<div class="header-sticky-inner">
						<div class="site-branding">
							<div class="site-title">
								<?php the_custom_logo(); ?>

								<?php if ( 'blank' !== get_theme_mod( 'header_textcolor', true ) ) : ?>
									<a href="<?php echo home_url( '/' ); ?>">
										<?php bloginfo( 'name' ); ?>
									</a>
								<?php endif; ?>
							</div><!-- /.site-title -->

							<?php if ( 'blank' !== get_theme_mod( 'header_textcolor', true ) ) : ?>
								<div class="site-description">
									<?php echo html_entity_decode( get_bloginfo( 'description' ) ); ?>
								</div><!-- /.site-description -->
							<?php endif; ?>
						</div><!-- /.site-branding -->

						<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<div class="site-navigation">
								<?php wp_nav_menu( array(
									'fallback_cb'       => '',
									'theme_location'    => 'primary',
								) ); ?>
							</div><!-- /.site-navigation -->
						<?php endif; ?>
					</div><!-- /.header-sticky-inner -->
				</div><!-- /.header-sticky -->
			</div><!-- /.header-inner -->
		</div><!-- /.header -->
	</div><!-- /.header-wrapper -->

	<?php do_action( 'listing_manager_front_before_main' ); ?>