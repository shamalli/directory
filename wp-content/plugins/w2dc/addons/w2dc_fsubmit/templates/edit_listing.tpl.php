<?php

// @codingStandardsIgnoreFile


$listing = $w2dc_instance->current_listing;
?>
<div class="w2dc-content">
	<?php w2dc_renderMessages(); ?>

	<h2><?php echo sprintf(esc_html__('Edit %s "%s"', 'w2dc'), $listing->directory->single, $listing->title()); ?></h2>

	<div class="w2dc-edit-listing-wrapper w2dc-row">
		<?php if ($listing_info): ?>
		<?php w2dc_renderTemplate($info_template, array('object' => $listing)); ?>
		<?php endif; ?>
		<div class="w2dc-edit-listing-form w2dc-col-md-<?php echo ($listing_info) ? 9: 12; ?>">
			<form action="" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="referer" value="<?php echo esc_attr($frontend_controller->referer); ?>" />
				<?php wp_nonce_field('w2dc_submit', '_submit_nonce'); ?>
		
				<div class="w2dc-submit-section w2dc-submit-section-title">
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('Listing title', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></h3>
					<div class="w2dc-submit-section-inside">
						<input type="text" name="post_title" class="w2dc-form-control" value="<?php if ($listing->post->post_title != esc_html__('Auto Draft')) echo esc_attr($listing->post->post_title); ?>" />
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
						<textarea name="post_excerpt" class="w2dc-form-control" rows="4"><?php echo esc_textarea($listing->post->post_excerpt)?></textarea>
						<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('summary')->description): ?><p class="w2dc-description"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('summary')->description); ?></p><?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				
				<?php do_action('w2dc_edit_listing_metaboxes_pre', $listing); ?>
		
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
							<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('categories_list')->description): ?><p class="w2dc-description"><?php w2dc_esc_e($w2dc_instance->content_fields->getContentFieldBySlug('categories_list')->description); ?></p><?php endif; ?>
						</div>
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
					<h3 class="w2dc-submit-section-label"><?php esc_html_e('Listing Media', 'w2dc'); ?></h3>
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
				
				<?php do_action('w2dc_edit_listing_metaboxes_post', $listing); ?>
		
				<?php require_once(ABSPATH . 'wp-admin/includes/template.php'); ?>
				<!-- <div class="w2dc-checkbox">
					<label>
						<input type="checkbox" name="w2dc_preview" value="1" <?php checked(w2dc_getValue($_REQUEST, 'w2dc_preview'), 1); ?> /> <?php esc_html_e('Open preview', 'w2dc'); ?>
					</label>
				</div>  -->
				<?php submit_button(esc_html__('Save changes', 'w2dc'), 'w2dc-btn w2dc-btn-primary', 'submit', false); ?>
				&nbsp;&nbsp;&nbsp;
				<?php submit_button(esc_html__('Cancel', 'w2dc'), 'w2dc-btn w2dc-btn-primary', 'cancel', false); ?>
			</form>
		</div>
	</div>
</div>