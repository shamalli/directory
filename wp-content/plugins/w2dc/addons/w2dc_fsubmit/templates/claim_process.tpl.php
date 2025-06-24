<h3>
	<?php
	// @codingStandardsIgnoreFile
	printf(esc_html__('Approve or decline claim of listing "%s"', 'w2dc'), $w2dc_instance->current_listing->title()); ?>
</h3>

<?php if ($frontend_controller->action == 'show'): ?>
<p><?php printf(esc_html__('User "%s" had claimed this listing.', 'w2dc'), $w2dc_instance->current_listing->claim->claimer->display_name); ?></p>
<?php if ($w2dc_instance->current_listing->claim->claimer_message): ?>
<p><?php esc_html_e('Message from claimer:', 'w2dc'); ?><br /><i><?php w2dc_esc_e($w2dc_instance->current_listing->claim->claimer_message); ?></i></p>
<?php endif; ?>
<p><?php esc_html_e('Claimer will receive email notification.', 'w2dc'); ?></p>

<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'process_claim', 'listing_id' => $w2dc_instance->current_listing->post->ID, 'claim_action' => 'approve', 'referer' => urlencode($frontend_controller->referer))); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Approve', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'process_claim', 'listing_id' => $w2dc_instance->current_listing->post->ID, 'claim_action' => 'decline', 'referer' => urlencode($frontend_controller->referer))); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Decline', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>
<?php elseif ($frontend_controller->action == 'processed'): ?>
<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Go back ', 'w2dc'); ?></a>
<?php endif; ?>