<?php

// @codingStandardsIgnoreFile

$listing = $w2dc_instance->current_listing;
?>
<div class="w2dc-content">
	<?php w2dc_renderMessages(); ?>

	<?php if (count($w2dc_instance->levels->levels_array) > 1): ?>
	<h3><?php echo sprintf(apply_filters('w2dc_create_option', esc_html__('Submit new %s in level "%s"', 'w2dc'), $listing), $directory->single, $listing->level->name); ?></h3>
	<?php endif; ?>

	<div class="w2dc-create-listing-wrapper w2dc-row">
		<div class="w2dc-create-listing-form w2dc-col-md-12">
			<form action="<?php echo w2dc_submitUrl(array('level' => $listing->level->id)); ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="listing_id" autocomplete="off" value="<?php w2dc_esc_e($listing->post->ID); ?>" />
				<input type="hidden" name="listing_id_hash" autocomplete="off" value="<?php echo md5($listing->post->ID . wp_salt()); ?>" />
				<?php wp_nonce_field('w2dc_submit', '_submit_nonce'); ?>
		
				<?php if (!is_user_logged_in() && (get_option('w2dc_fsubmit_login_mode') == 2 || get_option('w2dc_fsubmit_login_mode') == 3)): ?>
				<div class="w2dc-submit-section w2dc-submit-section-contact-info">
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('User info', 'w2dc'); ?></h3>
					<div class="w2dc-submit-section-inside">
						<label class="w2dc-fsubmit-contact"><?php esc_html_e('Your Name', 'w2dc'); ?><?php if (get_option('w2dc_fsubmit_login_mode') == 2): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></label>
						<input type="text" name="w2dc_user_contact_name" value="<?php echo esc_attr($frontend_controller->w2dc_user_contact_name); ?>" class="w2dc-form-control w2dc-width-100" />
		
						<label class="w2dc-fsubmit-contact"><?php esc_html_e('Your Email', 'w2dc'); ?><?php if (get_option('w2dc_fsubmit_login_mode') == 2): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></label>
						<input type="text" name="w2dc_user_contact_email" value="<?php echo esc_attr($frontend_controller->w2dc_user_contact_email); ?>" class="w2dc-form-control w2dc-width-100" />
						<p class="w2dc-description"><?php esc_html_e("Login information will be sent to your email after submission", "w2dc"); ?></p>
					</div>
				</div>
				<?php endif; ?>
		
				<div class="w2dc-submit-section w2dc-submit-section-title">
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('Listing title', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></h3>
					<div class="w2dc-submit-section-inside">
						<input type="text" name="post_title" class="w2dc-form-control w2dc-width-100" value="<?php if ($listing->post->post_title != esc_html__('Auto Draft', 'w2dc')) echo esc_attr($listing->post->post_title); ?>" />
					</div>
				</div>
		
				<?php if (post_type_supports(W2DC_POST_TYPE, 'editor')): ?>
				<div class="w2dc-submit-section w2dc-submit-section-description">
					<h3 class="w2dc-submit-section-label"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('content')->name); ?><?php if ($w2dc_instance->content_fields->getContentFieldBySlug('content')->is_required): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></h3>
					<div class="w2dc-submit-section-inside">
						<?php wp_editor($listing->post->post_content, 'post_content', $editor_options); ?>
						<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('content')->description): ?><p class="w2dc-description"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('content')->description); ?></p><?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
		
				<?php if (post_type_supports(W2DC_POST_TYPE, 'excerpt')): ?>
				<div class="w2dc-submit-section w2dc-submit-section-excerpt">
					<h3 class="w2dc-submit-section-label"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('summary')->name); ?><?php if ($w2dc_instance->content_fields->getContentFieldBySlug('summary')->is_required): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></h3>
					<div class="w2dc-submit-section-inside">
						<textarea name="post_excerpt" class="w2dc-editor-class w2dc-form-control" rows="4"><?php echo esc_textarea($listing->post->post_excerpt)?></textarea>
						<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('summary')->description): ?><p class="w2dc-description"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('summary')->description); ?></p><?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				
				<?php do_action('w2dc_create_listing_metaboxes_pre', $listing); ?>
		
				<?php if (!$listing->level->eternal_active_period && (get_option('w2dc_change_expiration_date') || current_user_can('manage_options'))): ?>
				<div class="w2dc-submit-section w2dc-submit-section-expiration-date">
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('Listing expiration date', 'w2dc'); ?></h3>
					<div class="w2dc-submit-section-inside">
						<?php $w2dc_instance->listings_manager->listingExpirationDateMetabox($listing->post); ?>
					</div>
				</div>
				<?php endif; ?>
		
				<?php if (get_option('w2dc_listing_contact_form') && get_option('w2dc_custom_contact_email')): ?>
				<div class="w2dc-submit-section w2dc-submit-section-contact-email">
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('Contact email', 'w2dc'); ?></h3>
					<div class="w2dc-submit-section-inside">
						<?php $w2dc_instance->listings_manager->listingContactEmailMetabox($listing->post); ?>
					</div>
				</div>
				<?php endif; ?>
				
				<?php if (get_option('w2dc_claim_functionality') && !get_option('w2dc_hide_claim_metabox')): ?>
				<div class="w2dc-submit-section w2dc-submit-section-claim">
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('Listing claim', 'w2dc'); ?></h3>
					<div class="w2dc-submit-section-inside">
						<?php $w2dc_instance->listings_manager->listingClaimMetabox($listing->post); ?>
					</div>
				</div>
				<?php endif; ?>
			
				<?php if ($listing->level->categories_number > 0 || $listing->level->unlimited_categories): ?>
				<div class="w2dc-submit-section w2dc-submit-section-categories">
					<h3 class="w2dc-submit-section-label"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('categories_list')->name); ?><?php if ($w2dc_instance->content_fields->getContentFieldBySlug('categories_list')->is_required): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></h3>
					<div class="w2dc-submit-section-inside">
						<a href="javascript:void(0);" class="w2dc-expand-terms"><?php esc_html_e('Expand All', 'w2dc'); ?></a> | <a href="javascript:void(0);" class="w2dc-collapse-terms"><?php esc_html_e('Collapse All', 'w2dc'); ?></a>
						<div class="w2dc-categories-tree-panel w2dc-editor-class" id="<?php echo W2DC_CATEGORIES_TAX; ?>-all">
							<?php w2dc_terms_checklist($listing->post->ID, $categories); ?>
						</div>
						<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('categories_list')->description): ?><p class="w2dc-description"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('categories_list')->description); ?></p><?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				
				<?php if ($listing->level->tags_number > 0 || $listing->level->unlimited_tags): ?>
				<div class="w2dc-submit-section w2dc-submit-section-tags">
					<h3 class="w2dc-submit-section-label"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('listing_tags')->name); ?> <i>(<?php esc_html_e('select existing or type new', 'w2dc'); ?>)</i></h3>
					<div class="w2dc-submit-section-inside">
						<?php w2dc_tags_selectbox($listing); ?>
						<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('listing_tags')->description): ?><p class="w2dc-description"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('listing_tags')->description); ?></p><?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
			
				<?php if ($w2dc_instance->content_fields->getNotCoreContentFields()): ?>
				<?php $w2dc_instance->content_fields->renderInputByGroups($listing->post); ?>
				<?php endif; ?>
			
				<?php if ($listing->level->images_number > 0 || $listing->level->videos_number > 0): ?>
				<div class="w2dc-submit-section w2dc-submit-section-media">
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('Listing Media', 'w2dc'); ?><?php if (get_option('w2dc_images_submit_required')): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></h3>
					<div class="w2dc-submit-section-inside">
						<?php $w2dc_instance->media_manager->mediaMetabox($listing->post, array('args' => array('target' => 'listings'))); ?>
					</div>
				</div>
				<?php endif; ?>
			
				<?php if ($listing->level->locations_number > 0): ?>
				<div class="w2dc-submit-section w2dc-submit-section-locations">
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('Listing locations', 'w2dc'); ?><?php if ($w2dc_instance->content_fields->getContentFieldBySlug('address')->is_required): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></h3>
					<div class="w2dc-submit-section-inside">
						<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('address')->description): ?><p class="w2dc-description"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('address')->description); ?></p><?php endif; ?>
						<?php $w2dc_instance->locations_manager->listingLocationsMetabox($listing->post); ?>
					</div>
				</div>
				<?php endif; ?>
				
				<?php do_action('w2dc_create_listing_metaboxes_post', $listing); ?>
		
				<?php if (get_option('w2dc_enable_recaptcha')): ?>
				<div class="w2dc-submit-section-adv">
					<?php echo w2dc_recaptcha(); ?>
				</div>
				<?php endif; ?>
		
				<?php
				if ($tos_page = w2dc_get_wpml_dependent_option('w2dc_tospage')) : ?>
				<div class="w2dc-submit-section-adv">
					<label><input type="checkbox" name="w2dc_tospage" value="1" /> <?php printf(esc_html__('I agree to the ', 'w2dc') . '<a href="%s" target="_blank">%s</a>', get_permalink($tos_page), esc_html__('Terms of Services', 'w2dc')); ?></label>
				</div>
				<?php endif; ?>
		
				<?php require_once(ABSPATH . 'wp-admin/includes/template.php'); ?>
				<?php submit_button(sprintf(esc_html__('Submit new %s', 'w2dc'), $directory->single), 'w2dc-btn w2dc-btn-primary'); ?>
			</form>
		</div>
	</div>
</div>