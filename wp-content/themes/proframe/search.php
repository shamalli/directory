<?php
// Get the customizer data.
$nav = get_theme_mod( 'proframe_posts_pagination', 'traditional' );
?>

<?php get_header(); ?>

	<header class="archive-header">
		<div class="container">
			<span class="browse"><?php esc_html_e( 'Search Results for', 'proframe' ); ?></span>
			<h1 class="archive-title"><?php echo get_search_query(); ?></h1>
		</div>
	</header><!-- .archive-header -->

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<?php if ( have_posts() ) : ?>

					<div class="posts-grid">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'partials/content', 'grid' ); ?>

						<?php endwhile; ?>

						<?php if ( $nav == 'load_more' ) {
							global $wp_query; ?>
							<?php if ( $wp_query->max_num_pages > 1 ) : ?>
								<a href="#" class="load-more-archive-posts"><?php esc_html_e( 'More Posts', 'proframe' ); ?></a>
							<?php endif; ?>
						<?php } ?>

					</div>

					<?php get_template_part( 'pagination' ); // Loads the pagination.php template  ?>

				<?php else : ?>

					<?php get_template_part( 'partials/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); // Loads the sidebar.php template. ?>

	</div><!-- .container -->

<?php get_footer(); ?>
