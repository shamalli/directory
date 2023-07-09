<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 */

get_header(); ?>

<?php 
	
	// Get content width and sidebar position
	$content_class = basel_get_content_class();
var_dump($content_class);

?>

<div class="site-content <?php echo esc_attr( $content_class ); ?>" role="main">

		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'basel' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div>

					<?php basel_entry_meta(); ?>

				</article><!-- #post -->

				<?php 
					// If comments are open or we have at least one comment, load up the comment template.
					if ( basel_get_opt('page_comments') && (comments_open() || get_comments_number()) ) :
						comments_template();
					endif;
				 ?>

		<?php endwhile; ?>

</div><!-- .site-content -->


<?php

$sidebar_class = basel_get_sidebar_class();

$sidebar_name = basel_get_sidebar_name();

?>

<aside class="sidebar-container <?php echo esc_attr( $sidebar_class ); ?> area-<?php echo esc_attr( $sidebar_name ); ?>">
		<div class="basel-close-sidebar-btn"><span><?php esc_html_e( 'Close', 'basel' ); ?></span></div>
		<div class="sidebar-inner basel-scroll">
			<div class="widget-area basel-sidebar-content">
				<?php do_action( 'basel_before_sidebar_area' ); ?>
				<?php dynamic_sidebar( $sidebar_name ); ?>
				<?php do_action( 'basel_after_sidebar_area' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</aside><!-- .sidebar-container -->


<?php get_footer(); ?>
