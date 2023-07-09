<?php
// Get the customizer data.
$type  = get_theme_mod( 'proframe_blog_types', 'default' );
$nav   = get_theme_mod( 'proframe_posts_pagination', 'traditional' );
$class = 'posts';

// Custom class
if ( $type == 'grid' ) {
	$class = 'posts-grid';
} elseif ( $type == 'list' ) {
	$class = 'posts-list';
} elseif ( $type == 'alternate' ) {
	$class = 'posts-alternate';
}
?>

<?php get_header(); ?>

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<?php if ( have_posts() ) : ?>

					<div class="<?php echo sanitize_html_class( $class ); ?>">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php if ( $type == 'default' ) { ?>
								<?php get_template_part( 'partials/content' ); ?>
							<?php } elseif ( $type == 'grid' ) { ?>
								<?php get_template_part( 'partials/content', 'grid' ); ?>
							<?php } elseif ( $type == 'list' ) { ?>
								<?php get_template_part( 'partials/content', 'list' ); ?>
							<?php } elseif ( $type == 'alternate' ) { ?>
								<?php if ( $wp_query->current_post == 0 && !is_paged() ) { ?>
									<?php get_template_part( 'partials/content' ); ?>
								<?php } else { ?>
									<?php get_template_part( 'partials/content', 'list' ); ?>
								<?php } ?>
							<?php } ?>

						<?php endwhile; ?>

						<?php if ( $nav == 'load_more' ) {
							global $wp_query; ?>
							<?php if ( $wp_query->max_num_pages > 1 ) : ?>
								<a href="#" class="load-more-posts"><?php esc_html_e( 'More Posts', 'proframe' ); ?></a>
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
