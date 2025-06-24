<?php

// @codingStandardsIgnoreFile

?>
<form method="POST" action="<?php the_permalink($listing->post->ID); ?>#contact-tab" id="w2dc_contact_form">
	<input type="hidden" name="listing_id" id="contact_listing_id" value="<?php w2dc_esc_e($listing->post->ID); ?>" />
	<input type="hidden" name="contact_nonce" id="contact_nonce" value="<?php echo wp_create_nonce('w2dc_contact_nonce'); ?>" />
	<h3><?php
		if (get_option('w2dc_hide_author_link'))
			esc_html_e('Send message to listing owner', 'w2dc');
		else
			printf(esc_html__('Send message to %s', 'w2dc'), get_the_author());
	?></h3>
	<h5 id="contact_warning" class="w2dc-contact-warning"></h5>
	<div class="w2dc-contact-form">
		<?php if (is_user_logged_in()): ?>
		<p>
			<?php printf(esc_html__('You are currently logged in as %s. Your message will be sent using your logged in name and email.', 'w2dc'), wp_get_current_user()->user_login); ?>
			<input type="hidden" name="contact_name" id="contact_name" />
			<input type="hidden" name="contact_email" id="contact_email" />
		</p>
		<?php else: ?>
		<p>
			<label for="contact_name"><?php esc_html_e('Contact Name', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
			<input type="text" name="contact_name" id="contact_name" class="w2dc-form-control" value="<?php echo esc_attr(w2dc_getValue($_POST, 'contact_name')); ?>" size="35" />
		</p>
		<p>
			<label for="contact_email"><?php esc_html_e("Contact Email", "w2dc"); ?><span class="w2dc-red-asterisk">*</span></label>
			<input type="text" name="contact_email" id="contact_email" class="w2dc-form-control" value="<?php echo esc_attr(w2dc_getValue($_POST, 'contact_email')); ?>" size="35" />
		</p>
		<?php endif; ?>
		<p>
			<label for="contact_message"><?php esc_html_e("Your message", "w2dc"); ?><span class="w2dc-red-asterisk">*</span></label>
			<textarea name="contact_message" id="contact_message" class="w2dc-form-control" rows="6"><?php echo esc_textarea(w2dc_getValue($_POST, 'contact_message')); ?></textarea>
		</p>
		
		<?php echo w2dc_recaptcha(); ?>
		
		<input type="submit" name="submit" class="w2dc-send-message-button w2dc-btn w2dc-btn-primary" value="<?php esc_attr_e('Send message', 'w2dc'); ?>" />
	</div>
</form>