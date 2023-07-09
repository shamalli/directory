<?php
/**
 * Template file
 *
 * @package Listing Manager Front
 * @subpackage Templates
 * @since 1.0.3
 */

?>

<div <?php comment_class( empty( $args['has_children'] ) ? '' : 'comments' ); ?> id="comment-<?php comment_ID() ?>">
    <div class="comment-wrapper">
        <div class="comment-image">
            <?php if ( 0 != $args['avatar_size']  ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
        </div><!-- /.comment-image -->

        <div class="comment-inner">
            <div class="comment-header">
                <h2><?php comment_author(); ?></h2>

                <div class="comment-header-meta">
                    <span class="comment-date"><?php echo get_comment_date(); ?></span>

                    <?php comment_reply_link( array_merge( $args, array(
    					'add_below'     => 'comment',
    					'depth'         => $depth,
    					'reply_text'    => esc_html__( 'Reply', 'listing-manager-front' ),
    					'max_depth'     => $args['max_depth'],
    	            ) ) ); ?>
                </div><!-- /.comment-header-meta -->
            </div><!-- /.comment-header -->

            <div class="comment-content-wrapper">
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- /.comment-content -->
            </div><!-- /.comment-content-wrapper -->

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <em class="comment-awaiting-moderation"><?php echo esc_attr__( 'Your comment is awaiting moderation.', 'listing-manager-front' ); ?></em>
                <br />
            <?php endif; ?>
        </div><!-- /.comment-content -->
    </div><!-- /.comment -->