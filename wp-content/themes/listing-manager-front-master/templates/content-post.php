<?php
/**
 * Template file
 *
 * @package Listing Manager Front
 * @subpackage Templates
 * @since 1.0.3
 */

?>

<?php global $post; ?>

<?php //if ( ! empty( $post->post_content ) ) : ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
		<?php //if ( ! is_singular() && has_post_thumbnail() ) : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'medium' ); ?>
				</a>
			</div><!-- /.post-thumbnail -->		

			<div class="post-title">
				<?php $categories = get_the_category(); ?>
				<?php if ( is_array( $categories ) && ! empty( $categories[0] ) ) : ?>
					<?php $category = $categories[0]; ?>
					<h4><?php echo esc_html( $category->name ); ?></h4>
				<?php endif; ?>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			</div><!-- /.post-title -->
		<?php //endif; ?>
		
		<div class="post-content">
			<?php if ( is_single() ) : ?>
				<?php the_content(); ?>
			<?php else : ?>
				<?php the_excerpt(); ?>
			<?php endif; ?>
		</div><!-- /.post-content -->

	    <?php wp_link_pages( array(
            'before'      => '<div class="pagination page-links"><span class="page-links-title">' . esc_attr__( 'Post Pages:', 'listing-manager-front' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span class="page-numbers">',
            'link_after'  => '</span>',
	    ) ); ?>

	    <?php if ( has_tag() ) : ?>
	        <div class="post-meta-tags clearfix">
	            <?php echo esc_attr__( 'Tags', 'listing-manager-front' ); ?>:
	            <ul>
	                <?php the_tags( '<li class="tag">', '</li><li class="tag">', '</li>' ); ?>
	            </ul>
	        </div><!-- /.post-meta -->
	    <?php endif; ?>			
	</div><!-- /.post -->

	<?php if ( comments_open() || get_comments_number() ) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>
<?php //endif; ?>