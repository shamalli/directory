<?php
/**
 * The template for displaying simple page
 *
 * Template name: Simple
 *
 * @package Listing Manager Front
 * @since Listing Manager Front 1.0.0
 */

get_header( 'simple' ); ?>

<a href="<?php echo site_url(); ?>" class="return-back">
	<i class="fa fa-long-arrow-left"></i> <?php echo esc_html__( 'Return Back', 'listing-manager-front' ); ?>
</a>

<div class="main-simple-wrapper">
	<div class="main-simple">
		<?php if ( have_posts() ): ?>
			<?php while( have_posts() ): the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div><!-- /.main-simple -->
</div><!-- /.main-simple-wrapper -->

<?php get_footer( 'simple' ); ?>
