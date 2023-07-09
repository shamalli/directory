<h3>
	<?php echo sprintf(esc_html__('Delete review "%s"', 'W2RR'), $review->title()); ?>
</h3>

<p><?php esc_html_e('Review will be completely deleted with all metadata, comments and attachments.', 'W2RR'); ?></p>

<a href="<?php echo w2rr_dashboardUrl(array('w2rr_action' => 'delete_review', 'review_id' => $review->post->ID, 'delete_action' => 'delete', 'referer' => urlencode($frontend_controller->referer))); ?>" class="w2rr-btn w2rr-btn-primary"><?php esc_html_e('Delete review', 'W2RR'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $frontend_controller->referer; ?>" class="w2rr-btn w2rr-btn-primary"><?php esc_html_e('Cancel', 'W2RR'); ?></a>