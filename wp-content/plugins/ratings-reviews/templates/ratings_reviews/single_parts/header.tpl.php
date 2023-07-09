<?php if (w2rr_show_edit_review_button($review->post->ID)): ?>
<div class="w2rr-content w2rr-review-frontpanel">
	<a class="w2rr-edit-review-link w2rr-btn w2rr-btn-primary" href="<?php echo w2rr_get_edit_review_link($review->post->ID); ?>" rel="nofollow" data-toggle="w2rr-tooltip" data-placement="top" data-original-title="<?php esc_attr_e('Edit review', 'W2RR'); ?>"><span class="w2rr-glyphicon w2rr-glyphicon-pencil"></span></a>
</div>
<?php endif; ?>
	
<?php if ($review->title()): ?>
<header class="w2rr-content w2rr-review-header">
	<?php $review->renderAvgRating(array('show_avg' => true, 'active' => false)); ?>

	<h4><?php esc_html_e('Review for', 'W2RR'); ?> <a href="<?php echo get_permalink($review->target_post->post); ?>"><?php echo $review->target_post->title(); ?></a></h4>
	<?php if (!get_option('w2rr_hide_views_counter')): ?>
	<div class="w2rr-meta-data">
		<div class="w2rr-views-counter">
			<span class="w2rr-glyphicon w2rr-glyphicon-eye-open"></span> <?php esc_html_e('views', 'W2RR')?>: <?php echo get_post_meta($review->post->ID, '_total_clicks', true); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if (!get_option('w2rr_hide_creation_date')): ?>
	<div class="w2rr-meta-data">
		<div class="w2rr-review-date" datetime="<?php echo date("Y-m-d", mysql2date('U', $review->post->post_date)); ?>T<?php echo date("H:i", mysql2date('U', $review->post->post_date)); ?>"><?php echo get_the_date(); ?> <?php echo get_the_time(); ?></div>
	</div>
	<?php endif; ?>
	<?php if ($review->getUserPicURL()): ?>
	<div class="w2rr-author-picture">
		<?php echo $review->renderUserPic(); ?>
	</div>
	<?php endif; ?>
	<?php if (!get_option('w2rr_hide_author_link')): ?>
	<div class="w2rr-meta-data">
		<div class="w2rr-author-link">
			<?php esc_html_e('By', 'W2RR'); ?> <?php echo get_the_author_link(); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if (get_option('w2rr_share_buttons') && get_option('w2rr_share_buttons_place') == 'title'): ?>
	<?php w2rr_renderTemplate('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $review->post->ID, 'post_url' => get_permalink($review->post->ID))); ?>
	<?php endif; ?>
	<?php $frontend_controller->printBreadCrumbs(); ?>
</header>
<?php endif; ?>