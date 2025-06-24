<?php $review = $object; ?>
		<div class="w2rr-edit-review-info w2rr-col-md-3">
			<div class="w2rr-submit-section">
				<h3 class="w2rr-submit-section-label"><?php esc_html_e('Post info', 'w2rr'); ?></h3>
				<div class="w2rr-submit-section-inside">
					<div class="w2rr-edit-review-info-label">
						<label><?php esc_html_e('Post', 'w2rr'); ?>:</label>
						<?php echo esc_html($review->target_post->title()); ?>
					</div>
					<?php if ($review->post->post_status == 'pending' || $review->post->post_status == 'draft'): ?>
					<div class="w2rr-edit-review-info-label">
						<label><?php esc_html_e('Post status', 'w2rr'); ?>:</label>
						<?php if ($review->post->post_status == 'pending') esc_html_e('Pending', 'w2rr'); ?>
						<?php if ($review->post->post_status == 'draft') esc_html_e('Draft', 'w2rr'); ?>
					</div>
					<?php endif; ?>
					<?php if (get_option('w2rr_enable_stats')): ?>
					<div class="w2rr-edit-review-info-label">
						<label><?php echo sprintf(esc_html__('Click stats: %d', 'w2rr'), (get_post_meta($review->post->ID, '_total_clicks', true) ? get_post_meta($review->post->ID, '_total_clicks', true) : 0)); ?></label>
					</div>
					<?php endif; ?>
					<?php if ($review->post->post_status == 'publish' && ($permalink = get_permalink($review->post->ID))): ?>
					<div class="w2rr-edit-review-info-label">
						<label><?php esc_html_e('View review', 'w2rr'); ?>:</label>
						<?php echo '<a href="' . $permalink . '" title="' . esc_attr__('view review', 'w2rr') . '" target="_blank">' . $review->title() . '</a>'; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>