<?php get_header(); ?>

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

						<div class="attachment-img post-thumbnail">
							<?php
								/**
								 * Filter the default image attachment size.
								 */
								$image_size = apply_filters( 'proframe_attachment_size', 'full' );

								echo wp_get_attachment_image( get_the_ID(), $image_size );
							?>
						</div><!-- .entry-attachment -->

						<div class="entry-content">

							<?php the_content(); ?>
							<?php
								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'proframe' ),
									'after'  => '</div>',
								) );
							?>

						</div>

					</article><!-- #post-## -->

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); // Loads the sidebar.php template. ?>

	</div><!-- .container -->

<?php get_footer(); ?>
