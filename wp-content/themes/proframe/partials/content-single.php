<?php
$size = 'proframe-post';
if ( in_array( get_theme_mod( 'theme_layout' ), array( 'full-width' ) ) ) {
	$size = 'proframe-post-large';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<?php
				the_post_thumbnail( $size, array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
			?>
		</div>
	<?php endif; ?>

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php proframe_post_meta(); ?>
		</div>

	</header>

	<div class="entry-content">

		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'proframe' ),
				'after'  => '</div>',
			) );
		?>

	</div>

	<footer class="entry-footer">

		<?php
			$tags   = get_the_tags();
			$enable = get_theme_mod( 'proframe_post_tags', 1 );
			$title  = get_theme_mod( 'proframe_post_tags_title', esc_html__( 'Topics', 'proframe' ) );
			if ( $enable && $tags ) :
		?>
			<span class="tag-links">
				<span class="tag-title block-title"><?php echo esc_html( $title ); ?></span>
				<?php foreach( $tags as $tag ) : ?>
					<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">#<?php echo esc_attr( $tag->name ); ?></a>
				<?php endforeach; ?>
			</span>
		<?php endif; ?>

	</footer>

</article><!-- #post-## -->
