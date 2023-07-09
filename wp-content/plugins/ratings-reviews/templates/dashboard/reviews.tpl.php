	<?php if ($frontend_controller->reviews): ?>
		<table class="w2rr-table w2rr-dashboard-reviews w2rr-table-striped">
			<tr>
				<th class="w2rr-td-review-title"><?php esc_html_e('Title', 'W2RR'); ?></th>
				<th class="w2rr-td-review-post"><?php esc_html_e('Post', 'W2RR'); ?></th>
				<th class="w2rr-td-review-date"><?php esc_html_e('Date', 'W2RR'); ?></th>
				<th class="w2rr-td-review-options"></th>
			</tr>
		<?php foreach ($frontend_controller->reviews AS $review): ?>
			<?php $target_post = $review->target_post; ?>
			<tr>
				<td class="w2rr-td-review-title">
				<?php if (w2rr_current_user_can_edit_review($review->post->ID)): ?>
				<a href="<?php echo w2rr_get_edit_review_link($review->post->ID); ?>"><?php echo esc_html($review->title()); ?></a> <?php $review->renderStars(); ?>
				<?php else: ?>
				<?php echo esc_html($review->title()); ?>
				<?php endif; ?>
				<?php if ($review->post->post_status == 'pending') echo ' - ' . esc_html__('Pending review', 'W2RR'); ?>
				</td>
				<td class="w2rr-td-post-title">
				<?php if ($target_post): ?>
					<?php if (w2rr_current_user_can_edit_target_post($target_post->post->ID)): ?>
					<a href="<?php echo w2rr_get_edit_target_post_link($target_post->post->ID); ?>"><?php echo esc_html($target_post->title()); ?></a>
					<?php else: ?>
					<?php echo esc_html($target_post->title()); ?>
					<?php endif; ?>
				<?php endif; ?>
				</td>
				<td class="w2rr-td-post-date">
					<?php echo get_the_date('', $review->post->ID) . ' ' . get_the_time('', $review->post->ID); ?>
				</td>
				<td class="w2rr-td-review-options">
					<?php if (w2rr_current_user_can_edit_review($review->post->ID)): ?>
					<div class="w2rr-btn-group">
						<a href="<?php echo w2rr_get_edit_review_link($review->post->ID); ?>" class="w2rr-btn w2rr-btn-primary w2rr-btn-sm w2rr-dashboard-edit-btn" title="<?php esc_attr_e('edit review', 'W2RR'); ?>"><span class="w2rr-glyphicon w2rr-glyphicon-edit"></span></a>
						<a href="<?php echo w2rr_get_edit_review_link($review->post->ID); ?>" class="w2rr-dashboard-btn-mobile"><?php esc_html_e('edit', 'W2RR'); ?></a>
						<a href="<?php echo w2rr_dashboardUrl(array('w2rr_action' => 'delete_review', 'review_id' => $review->post->ID)); ?>" class="w2rr-btn w2rr-btn-primary w2rr-btn-sm w2rr-dashboard-delete-btn" title="<?php esc_attr_e('delete review', 'W2RR'); ?>"><span class="w2rr-glyphicon w2rr-glyphicon-trash"></span></a>
						<a href="<?php echo w2rr_dashboardUrl(array('w2rr_action' => 'delete_review', 'review_id' => $review->post->ID)); ?>" class="w2rr-dashboard-btn-mobile"><?php esc_html_e('delete', 'W2RR'); ?></a>
						<?php
						if (get_option('w2rr_enable_stats')) {
							echo '<a href="' . w2rr_dashboardUrl(array('w2rr_action' => 'view_review_stats', 'review_id' => $review->post->ID)) . '" class="w2rr-btn w2rr-btn-primary w2rr-btn-sm w2rr-dashboard-stats-btn" title="' . esc_html__('view clicks stats', 'W2RR') . '"><span class="w2rr-glyphicon w2rr-glyphicon-signal"></span></a>';
							echo '<a href="' . w2rr_dashboardUrl(array('w2rr_action' => 'view_review_stats', 'review_id' => $review->post->ID)) . '" class="w2rr-dashboard-btn-mobile">' . esc_html__('stats', 'W2RR') . '</a>';
						}?>
						<?php
						if ($review->post->post_status == 'publish' && $permalink = get_permalink($review->post->ID)) {
							echo '<a href="' . $permalink . '" class="w2rr-btn w2rr-btn-primary w2rr-btn-sm w2rr-dashboard-view-btn" title="' . esc_attr__('view review', 'W2RR') . '"><span class="w2rr-glyphicon w2rr-glyphicon-link"></span></a>';
							echo '<a href="' . $permalink . '" class="w2rr-dashboard-btn-mobile">' . esc_html__('view', 'W2RR') . '</a>';
						}?>
						<?php do_action('w2rr_dashboard_review_options', $target_post); ?>
					</div>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php w2rr_renderPaginator($reviews_controller->query, ''); ?>
		<?php endif; ?>