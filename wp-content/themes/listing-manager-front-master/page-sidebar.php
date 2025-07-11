<?php
/**
 * The template for displaying front page
 *
 * Template name: With Sidebar
 * 
 */
?>

<?php get_header(); ?>

<div class="content">
	<?php if ( have_posts() ) : ?>
		<div class="posts">
			<?php while ( have_posts() ) : the_post(); ?>		
				<?php get_template_part( 'templates/content', get_post_type() );?>
			<?php endwhile; ?>
		</div><!-- /.posts -->
	
	    <?php listing_manager_front_pagination(); ?>
	<?php else : ?>
	    <?php get_template_part( 'templates/content', 'none' ); ?>		
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>