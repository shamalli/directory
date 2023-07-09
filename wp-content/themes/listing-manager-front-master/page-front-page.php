<?php
/**
 * The template for displaying front page
 *
 * Template name: Front
 *
 * @package Listing Manager Front
 * @since Listing Manager Front 1.0.0
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>