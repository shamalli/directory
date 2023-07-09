<?php get_header(); ?>

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'partials/content', 'single' ); ?>

					<?php proframe_next_prev_post(); // Display the next and previous post. ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar( 'portfolio' ); // Loads the sidebar.php template. ?>

	</div><!-- .container -->

<?php get_footer(); ?>
