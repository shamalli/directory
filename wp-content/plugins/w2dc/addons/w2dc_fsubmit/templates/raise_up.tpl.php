<?php

// @codingStandardsIgnoreFile

?>
<h3>
	<?php echo apply_filters('w2dc_raiseup_option', sprintf(esc_html__('Raise up listing "%s"', 'w2dc'), $w2dc_instance->current_listing->title()), $w2dc_instance->current_listing); ?>
</h3>

<p><?php esc_html_e('Listing will be raised up to the top of all lists, those ordered by date.', 'w2dc'); ?></p>
<p><?php esc_html_e('Note, that listing will not stick on top, so new listings and other listings, those were raised up later, will place higher.', 'w2dc'); ?></p>

<?php do_action('w2dc_raise_up_html', $w2dc_instance->current_listing); ?>

<?php if ($frontend_controller->action == 'show'): ?>
<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'raiseup_listing', 'listing_id' => $w2dc_instance->current_listing->post->ID, 'raiseup_action' => 'raiseup', 'referer' => urlencode($frontend_controller->referer))); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Raise up', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>
<?php elseif ($frontend_controller->action == 'raiseup'): ?>
<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Go back ', 'w2dc'); ?></a>
<?php endif; ?>