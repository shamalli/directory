<h3>
	<?php
	// @codingStandardsIgnoreFile
	echo apply_filters('w2dc_claim_option', sprintf(esc_html__('Claim listing "%s"', 'w2dc'), $w2dc_instance->current_listing->title()), $w2dc_instance->current_listing); ?>
</h3>

<!-- <?php if ($frontend_controller->action == 'show'): ?>
<?php if (get_option('w2dc_claim_approval')): ?>
<p><?php esc_html_e('The notification about claim for this listing will be sent to the current listing owner.', 'w2dc'); ?></p>
<p><?php esc_html_e("After approval you will become owner of this listing, you'll receive email notification.", 'w2dc'); ?></p>
<?php endif; ?>
<?php if (get_option('w2dc_after_claim') == 'expired'): ?>
<p><?php echo esc_html__('After approval listing status become expired.', 'w2dc') . ((get_option('w2dc_payments_addon')) ? apply_filters('w2dc_renew_option', esc_html__(' The price for renewal', 'w2dc'), $w2dc_instance->current_listing) : ''); ?></p>
<?php endif; ?> -->

<?php do_action('w2dc_claim_html', $w2dc_instance->current_listing); ?>

<form method="post" action="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'claim_listing', 'listing_id' => $w2dc_instance->current_listing->post->ID, 'claim_action' => 'claim')); ?>">
	<input type="hidden" name="referer" value="<?php echo esc_attr($frontend_controller->referer); ?>" />
	<div class="w2dc-form-group w2dc-row">
		<div class="w2dc-col-md-12">
			<textarea name="claim_message" class="w2dc-form-control" rows="5"></textarea>
			<p class="description"><?php esc_html_e('additional information to moderator', 'w2dc'); ?></p>
		</div>
	</div>
	<input type="submit" class="w2dc-btn w2dc-btn-primary" value="<?php esc_attr_e('Send Claim', 'w2dc'); ?>"></input>
	&nbsp;&nbsp;&nbsp;
	<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>
</form>
<?php elseif ($frontend_controller->action == 'claim'): ?>
<a href="<?php echo esc_attr($frontend_controller->referer); ?>" class="w2dc-btn w2dc-btn-primary"><?php esc_html_e('Go back ', 'w2dc'); ?></a>
<?php endif; ?>