<?php

// @codingStandardsIgnoreFile

?>
<h3>
	<?php echo sprintf(esc_html__('Delete listing "%s"', 'w2dc'), $w2dc_instance->current_listing->title()); ?>
</h3>

<p><?php esc_html_e('Listing will be completely deleted with all metadata, comments and attachments.', 'w2dc'); ?></p>

<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'delete_listing', 'listing_id' => $w2dc_instance->current_listing->post->ID, 'delete_action' => 'delete', 'referer' => urlencode($frontend_controller->referer))); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Delete listing', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>