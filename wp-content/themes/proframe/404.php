<?php get_header(); ?>

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<section class="error-404 not-found">

					<header class="not-found-header">
						<h1 class="not-found-title"><?php esc_html_e( '404', 'proframe' ); ?></h1>
					</header><!-- .not-found-header -->

					<div class="not-found-content">
						<h3><?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'proframe' ); ?></h3>
						<p><?php esc_html_e( 'You can go back to the Homepage or maybe try our search box below', 'proframe' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .notfound-content -->

				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .container -->

<?php get_footer(); ?>
