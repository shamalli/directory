<?php $review = $object; ?>
		<div class="w2rr-edit-review-info w2rr-col-md-3">
			<div class="w2rr-submit-section">
				<h3 class="w2rr-submit-section-label"><?php esc_html_e('Post info', 'W2RR'); ?></h3>
				<div class="w2rr-submit-section-inside">
					<div class="w2rr-edit-review-info-label">
						<label><?php esc_html_e('Post', 'W2RR'); ?>:</label>
						<?php echo esc_html($review->target_post->title()); ?>
					</div>
					<?php if ($review->post->post_status == 'pending' || $review->post->post_status == 'draft'): ?>
					<div class="w2rr-edit-review-info-label">
						<label><?php esc_html_e('Post status', 'W2RR'); ?>:</label>
						<?php if ($review->post->post_status == 'pending') esc_html_e('Pending', 'W2RR'); ?>
						<?php if ($review->post->post_status == 'draft') esc_html_e('Draft', 'W2RR'); ?>
					</div>
					<?php endif; ?>
					<?php if (get_option('w2rr_enable_stats')): ?>
					<div class="w2rr-edit-review-info-label">
						<label><?php echo sprintf(esc_html__('Click stats: %d', 'W2RR'), (get_post_meta($review->post->ID, '_total_clicks', true) ? get_post_meta($review->post->ID, '_total_clicks', true) : 0)); ?></label>
					</div>
					<?php endif; ?>
					<?php if ($review->post->post_status == 'publish' && ($permalink = get_permalink($review->post->ID))): ?>
					<div class="w2rr-edit-review-info-label">
						<label><?php esc_html_e('View review', 'W2RR'); ?>:</label>
						<?php echo '<a href="' . $permalink . '" title="' . esc_attr__('view review', 'W2RR') . '" target="_blank">' . $review->title() . '</a>'; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>