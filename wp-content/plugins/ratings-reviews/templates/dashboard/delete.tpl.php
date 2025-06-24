<h3>
	<?php echo sprintf(esc_html__('Delete review "%s"', 'w2rr'), $review->title()); ?>
</h3>

<p><?php esc_html_e('Review will be completely deleted with all metadata, comments and attachments.', 'w2rr'); ?></p>

<a href="<?php echo w2rr_dashboardUrl(array('w2rr_action' => 'delete_review', 'review_id' => $review->post->ID, 'delete_action' => 'delete', 'referer' => urlencode($frontend_controller->referer))); ?>" class="w2rr-btn w2rr-btn-primary"><?php esc_html_e('Delete review', 'w2rr'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php w2rr_esc_e($frontend_controller->referer); ?>" class="w2rr-btn w2rr-btn-primary"><?php esc_html_e('Cancel', 'w2rr'); ?></a>