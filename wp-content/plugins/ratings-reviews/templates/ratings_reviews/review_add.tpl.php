<?php
	if (!defined('ABSPATH')) die('You cannot access this template file directly');
?>

<div class="w2rr-content">
	<?php w2rr_renderMessages(); ?>

	<?php if (w2rr_can_user_add_review($target_post->post->ID) && isset($review)): ?>
	<h3><?php echo sprintf(esc_html__('Add Review to "%s"', 'w2rr'), $target_post->title()); ?></h3>

	<form action="<?php echo w2rr_get_add_review_link($target_post->post->ID); ?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="review_id" autocomplete="off" value="<?php echo esc_attr($review->post->ID); ?>" />
		<input type="hidden" name="review_id_hash" autocomplete="off" value="<?php echo md5($review->post->ID . wp_salt()); ?>" />
		<?php wp_nonce_field('w2rr_submit', '_submit_nonce'); ?>

		<?php if (!is_user_logged_in() && in_array(get_option('w2rr_reviews_allowed_users'), array('guests', 'required_contact_form'))): ?>
		<div class="w2rr-submit-section w2rr-submit-section-contact-info">
			<h3 class="w2rr-submit-section-label"><?php esc_html_e('User info', 'w2rr'); ?></h3>
			<div class="w2rr-submit-section-inside">
				<label class="w2rr-fsubmit-contact"><?php esc_html_e('Your Name', 'w2rr'); ?><?php if (get_option('w2rr_reviews_allowed_users') == 'required_contact_form'): ?><span class="w2rr-red-asterisk">*</span><?php endif; ?></label>
				<input type="text" name="w2rr_user_contact_name" value="<?php echo esc_attr($frontend_controller->w2rr_user_contact_name); ?>" class="w2rr-form-control w2rr-width-100" />

				<label class="w2rr-fsubmit-contact"><?php esc_html_e('Your Email', 'w2rr'); ?><?php if (get_option('w2rr_reviews_allowed_users') == 'required_contact_form'): ?><span class="w2rr-red-asterisk">*</span><?php endif; ?></label>
				<input type="text" name="w2rr_user_contact_email" value="<?php echo esc_attr($frontend_controller->w2rr_user_contact_email); ?>" class="w2rr-form-control w2rr-width-100" />
				<p class="w2rr-description"><?php esc_html_e("Login information will be sent to your email after submission", "w2rr"); ?></p>
			</div>
		</div>
		<?php endif; ?>

		<div class="w2rr-submit-section w2rr-submit-section-title">
			<h3 class="w2rr-submit-section-label"><?php esc_html_e('Review title', 'w2rr'); ?><span class="w2rr-red-asterisk">*</span></h3>
			<div class="w2rr-submit-section-inside">
				<input type="text" name="post_title" class="w2rr-form-control w2rr-width-100" value="<?php if ($review->post->post_title != esc_html__('Auto Draft', 'w2rr')) echo esc_attr($review->title()); ?>" />
			</div>
		</div>
		
		<div class="w2rr-submit-section w2rr-submit-section-rating">
			<?php if (!w2rr_getMultiRatings()): ?>
			<h3 class="w2rr-submit-section-label"><?php esc_html_e('Review rating', 'w2rr'); ?><span class="w2rr-red-asterisk">*</span></h3>
			<div class="w2rr-submit-section-inside">
				<?php w2rr_renderAvgRating($review->avg_rating, $review->post->ID, array('noajax' => true, 'meta_tags' => false, 'active' => true, 'show_avg' => false, 'show_counter' => false)); ?>
			</div>
			<?php else: ?>
			<h3 class="w2rr-submit-section-label"><?php esc_html_e('Review ratings', 'w2rr'); ?></h3>
			<div class="w2rr-submit-section-inside">
				<?php $w2rr_instance->reviews_manager->ratingsCriteriasMetabox($review->post); ?>
			</div>
			<?php endif; ?>
		</div>

		<?php if (get_option('w2rr_enable_description') || get_option('w2rr_enable_pros_cons')): ?>
		<div class="w2rr-submit-section w2rr-submit-section-description">
			<?php if (get_option('w2rr_enable_description')): ?>
			<h3 class="w2rr-submit-section-label"><?php esc_html_e('Description', 'w2rr'); ?><span class="w2rr-red-asterisk">*</span></h3>
			<div class="w2rr-submit-section-inside">
				<?php
				wp_editor($review->post->post_content, 'post_content', array(
					'media_buttons' => false,
					'editor_class' => 'w2rr-editor-class',
					'tinymce' => false,
					'quicktags' => false
				)); ?>
			</div>
			<?php endif; ?>
			<?php if (get_option('w2rr_enable_pros_cons')): ?>
			<div class="w2rr-submit-section-inside">
				<p><?php esc_html_e('Pros and Cons', 'w2rr')?></p>
				<div class="w2rr-row">
					<div class="w2rr-col-md-6">
						<textarea name="pros" class="w2rr-form-control w2rr-pros-description" rows="4" placeholder="<?php esc_attr_e('Describe advantages...', 'w2rr')?>"><?php echo esc_textarea($review->pros)?></textarea>
					</div>
					<div class="w2rr-col-md-6">
						<textarea name="cons" class="w2rr-form-control w2rr-cons-description" rows="4" placeholder="<?php esc_attr_e('Describe disadvantages...', 'w2rr')?>"><?php echo esc_textarea($review->cons)?></textarea>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		
		<?php if (get_option('w2rr_enable_summary')): ?>
		<div class="w2rr-submit-section w2rr-submit-section-excerpt">
			<h3 class="w2rr-submit-section-label"><?php esc_html_e('Summary', 'w2rr'); ?></h3>
			<div class="w2rr-submit-section-inside">
				<textarea name="post_excerpt" class="w2rr-form-control" rows="4"><?php echo esc_textarea($review->post->post_excerpt)?></textarea>
			</div>
		</div>
		<?php endif; ?>
	
		<?php if (get_option("w2rr_reviews_images_number") > 0): ?>
		<div class="w2rr-submit-section w2rr-submit-section-media">
			<h3 class="w2rr-submit-section-label"><?php esc_html_e('Review Media', 'w2rr'); ?></h3>
			<div class="w2rr-submit-section-inside">
				<?php $w2rr_instance->media_manager->mediaMetabox($review->post, array('args' => array('target' => 'reviews'))); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<?php do_action('w2rr_create_review_metaboxes_post', $review); ?>

		<?php if (get_option('w2rr_enable_recaptcha')): ?>
		<div class="w2rr-submit-section-adv">
			<?php echo w2rr_recaptcha(); ?>
		</div>
		<?php endif; ?>

		<?php
		if ($tos_page = w2rr_get_wpml_dependent_option('w2rr_tospage')) : ?>
		<div class="w2rr-submit-section-adv">
			<label><input type="checkbox" name="w2rr_tospage" value="1" /> <?php printf(esc_html__('I agree to the ', 'w2rr') . '<a href="%s" target="_blank">%s</a>', get_permalink($tos_page), esc_html__('Terms of Services', 'w2rr')); ?></label>
		</div>
		<?php endif; ?>

		<?php require_once(ABSPATH . 'wp-admin/includes/template.php'); ?>
		<?php submit_button(esc_html__('Submit review', 'w2rr'), 'w2rr-btn w2rr-btn-primary')?>
	</form>
	<?php endif; ?>
</div>