<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">

	<?php if ( has_nav_menu ( 'mobile' ) ) : ?>
		<nav class="mobile-navigation">
			<a href="#" class="menu-toggle"><i class="icon-cancel"></i> <?php esc_html_e( 'Close Menu', 'proframe' ); ?></a>
			<?php wp_nav_menu(
				array(
					'theme_location'  => 'mobile',
					'menu_id'         => 'menu-mobile-items',
					'menu_class'      => 'menu-mobile-items',
					'container'       => false
				)
			); ?>
		</nav>
	<?php endif; ?>

	<div class="wide-container">

		<header id="masthead" class="site-header">
			<div class="container">

				<?php proframe_site_branding(); ?>

				<?php if ( has_nav_menu ( 'primary' ) ) : ?>
					<nav class="main-navigation" id="site-navigation">
						<?php wp_nav_menu(
							array(
								'theme_location'  => 'primary',
								'menu_id'         => 'menu-primary-items',
								'menu_class'      => 'menu-primary-items',
								'container'       => false
							)
						); ?>

						<?php if ( has_nav_menu ( 'mobile' ) ) : ?>
							<a href="#" class="menu-toggle"><i class="icon-menu"></i></a>
						<?php endif; ?>

						<?php
							$search = get_theme_mod( 'proframe_search_icon', 1 );
							if ( $search ) :
						?>
							<div class="search-icon">
								<a href="#search-overlay" class="search-toggle">
									<i class="icon-search"></i>
								</a>
							</div>
						<?php endif; ?>

					</nav>
				<?php endif; ?>

			</div><!-- .container -->
		</header><!-- #masthead -->

		<div id="content" class="site-content">
