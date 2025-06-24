<?php

// @codingStandardsIgnoreFile

?>
<h3>
	<?php echo apply_filters('w2dc_renew_option', sprintf(esc_html__('Renew listing "%s"', 'w2dc'), $w2dc_instance->current_listing->title()), $w2dc_instance->current_listing); ?>
</h3>

<p><?php esc_html_e('Listing will be renewed and raised up.', 'w2dc'); ?></p>

<?php do_action('w2dc_renew_html', $w2dc_instance->current_listing); ?>

<?php if ($frontend_controller->action == 'show'): ?>
<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'renew_listing', 'listing_id' => $w2dc_instance->current_listing->post->ID, 'renew_action' => 'renew', 'referer' => urlencode($frontend_controller->referer))); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Renew listing', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>
<?php elseif ($frontend_controller->action == 'renew'): ?>
<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Go back ', 'w2dc'); ?></a>
<?php endif; ?>