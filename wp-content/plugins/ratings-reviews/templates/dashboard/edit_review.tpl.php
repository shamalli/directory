<div class="w2rr-content">
	<?php w2rr_renderMessages(); ?>

	<h2><?php echo sprintf(esc_html__('Edit Review "%s"', 'w2rr'), $review->title()); ?></h2>

	<div class="w2rr-edit-review-wrapper w2rr-row">
		<?php if ($post_info): ?>
		<?php w2rr_renderTemplate($info_template, array('object' => $review)); ?>
		<?php endif; ?>
		<div class="w2rr-edit-review-form w2rr-col-md-<?php echo ($post_info) ? 9: 12; ?>">
			<form action="" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="referer" value="<?php w2rr_esc_e($frontend_controller->referer); ?>" />
				<?php wp_nonce_field('w2rr_submit', '_submit_nonce'); ?>
				
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
		
				<?php if (get_option('w2rr_enable_description')): ?>
				<div class="w2rr-submit-section w2rr-submit-section-description">
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
				
				<?php do_action('w2rr_edit_review_metaboxes_post', $review); ?>
		
				<?php require_once(ABSPATH . 'wp-admin/includes/template.php'); ?>
				<?php submit_button(esc_html__('Save changes', 'w2rr'), 'w2rr-btn w2rr-btn-primary', 'submit', false); ?>
				&nbsp;&nbsp;&nbsp;
				<?php submit_button(esc_html__('Cancel', 'w2rr'), 'w2rr-btn w2rr-btn-primary', 'cancel', false); ?>
			</form>
		</div>
	</div>
</div>