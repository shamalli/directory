<div class="w2rr-content w2rr-reviews-metabox">
	<?php if (apply_filters('w2rr_comments_open_metabox_setting', true, $target_post)): ?>
	<p class="meta-options">
		<?php if (get_option('w2rr_display_mode') == 'comments'): ?>
		<label for="comment_status" class="selectit">
			<input name="comment_status" type="checkbox" id="comment_status" value="open" <?php checked($target_post->post->comment_status, 'open'); ?> /> <?php _e('Enable reviews on this page', 'W2RR'); ?>
		</label>
		<?php elseif (get_option('w2rr_display_mode') == 'shortcodes'): ?>
		<label for="review_status" class="selectit">
			<input name="review_status" type="checkbox" id="review_status" value="open" <?php if (!get_post_meta($target_post->post->ID, '_review_status', true) || get_post_meta($target_post->post->ID, '_review_status', true) == 'open') echo "checked"; ?> /> <?php _e('Enable reviews on this page', 'W2RR'); ?>
		</label>
		<?php endif; ?>
	</p>
	<?php endif; ?>
	<?php do_action('w2rr_comments_open_metabox', $target_post); ?>
	
	<?php w2rr_renderTemplate('ratings_reviews/add_review_button.tpl.php', array('post_id' => $target_post->post->ID)); ?>
	
	<?php if ($reviews): ?>
	<table style="width: 100%;">
		<tr>
			<th style="text-align: left;"><?php esc_html_e('Review title', 'W2RR'); ?></th>
			<th style="text-align: left;"><?php esc_html_e('Rating', 'W2RR'); ?></th>
			<th style="text-align: left;"><?php esc_html_e('Date', 'W2RR'); ?></th>
			<th style="text-align: left;"></th>
		</tr>
		<?php foreach ($reviews AS $review): ?>
		<tr>
			<td>
			<?php if (w2rr_current_user_can_edit_review($review->post->ID)): ?>
			<a href="<?php echo w2rr_get_edit_review_link($review->post->ID); ?>"><?php echo esc_html($review->title()); ?></a>
			<?php else: ?>
			<?php echo esc_html($review->title()); ?>
			<?php endif; ?>
			<?php if ($review->post->post_status == 'pending') echo ' - ' . esc_html__('Pending review', 'W2RR'); ?>
			</td>
			<td>
				<?php $review->renderStars(); ?>
			</td>
			<td>
				<?php echo get_the_date('', $review->post->ID) . ' ' . get_the_time('', $review->post->ID); ?>
			</td>
			<td>
				<?php if (w2rr_current_user_can_edit_review($review->post->ID)): ?>
				<div class="w2rr-btn-group">
					<a href="<?php echo w2rr_get_edit_review_link($review->post->ID); ?>"><?php esc_html_e('edit', 'W2RR'); ?></a>
					<?php
					if ($review->post->post_status == 'publish' && $permalink = get_permalink($review->post->ID)) {
						echo '<a href="' . $permalink . '">' . esc_html__('view', 'W2RR') . '</a>';
					}?>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php foreach ($avg_rating->ratings AS $rating): ?>
		<?php if ($rating->user): ?>
		<tr class="w2rr-delete-rating-tr">
			<td>
				<?php esc_html_e('User rating', 'W2RR')?>: <?php if (is_object($rating->user)) echo $rating->user->user_login; else echo $rating->user; ?>
			</td>
			<td>
				<?php w2rr_renderTemplate('ratings_reviews/single_rating.tpl.php', array('rating' => $rating)); ?>
			</td>
			<td></td>
			<td>
				<a href="javascript:void(0);" class="w2rr-delete-single-rating" data-post-id="<?php echo esc_attr($target_post->post->ID); ?>" data-rating-key="<?php echo esc_attr($rating->key); ?>" data-nonce="<?php echo wp_create_nonce('delete_rating')?>"><?php esc_html_e('delete', 'W2RR'); ?></a>
			</td>
		</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
</div>