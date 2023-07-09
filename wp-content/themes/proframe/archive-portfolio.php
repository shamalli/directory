<?php
// Get the column setting
$columns = get_theme_mod( 'proframe_portfolio_columns', 'proframe-three-columns' );

// Wrapper classes
$wrap_classes = array( 'proframe-portfolio', 'proframe-items' );
$wrap_classes[] = $columns;
$wrap_classes = implode( ' ', $wrap_classes );

get_header(); ?>

	<?php proframe_archive_header(); ?>

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<?php if ( have_posts() ) : ?>

					<div class="<?php echo esc_attr( $wrap_classes ); ?>">

						<?php while ( have_posts() ) : the_post(); ?>

							<article <?php post_class( 'proframe-item' ); ?>>

								<div class="thumbnail">
									<a class="post-thumbnail" href="<?php the_permalink(); ?>">

										<?php
											the_post_thumbnail( 'proframe-portfolio', array(
												'alt' => the_title_attribute( array(
													'echo' => false,
												) ),
											) );
										?>

										<span class="thumbnail-overlay">
											<span class="overlay-content">

												<?php the_title( '<h5 class="overlay-title">', '</h5>' ); ?>

											</span>
										</span>

									</a>
								</div>

							</article>

						<?php endwhile; ?>

					</div>

					<?php global $wp_query; if ( $wp_query->max_num_pages > 1 ) : ?>
						<nav class="navigation pagination">
							<h2 class="screen-reader-text"><?php esc_html_e( 'Portfolio navigation', 'proframe' ) ?></h2>
							<div class="nav-page">
								<div class="nav-newer newer"><?php previous_posts_link( esc_html__( '&laquo; Newer projects', 'proframe' ) ); ?></div>
								<div class="nav-older older"><?php next_posts_link( esc_html__( 'Older projects &raquo;', 'proframe' ) ); ?></div>
							</div>
						</nav>
					<?php endif; ?>

				<?php else : ?>

					<?php get_template_part( 'partials/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar( 'portfolio' ); // Loads the sidebar-portfolio.php template. ?>

	</div><!-- .container -->

<?php get_footer(); ?>
