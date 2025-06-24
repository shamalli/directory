<?php

// @codingStandardsIgnoreFile

?>
<div id="misc-publishing-actions">
	<?php if ($w2dc_instance->directories->isMultiDirectory()): ?>
	<script>
		(function($) {
			"use strict";
	
			$(function() {
				$("#directory_id").on("change", function() {
					$("#publish").trigger('click');
				});
			});
		})(jQuery);
	</script>
	<div class="misc-pub-section">
		<label for="post_level"><?php esc_html_e('Directory', 'w2dc'); ?>:</label>
		<select id="directory_id" name="directory_id">
			<?php foreach ($w2dc_instance->directories->directories_array AS $directory): ?>
			<option value="<?php w2dc_esc_e($directory->id); ?>" <?php selected($directory->id, $listing->directory->id, true); ?>><?php w2dc_esc_e($directory->name); ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php endif; ?>

	<div class="misc-pub-section">
		<label for="post_level"><?php esc_html_e('Listing level', 'w2dc'); ?>:</label>
		<span id="post-level-display">
			<?php
			if ($listing->listing_created && $listing->level->isUpgradable())
					echo '<a href="' . admin_url('options.php?page=w2dc_upgrade&listing_id=' . $listing->post->ID) . '">';
			else
				echo '<b>'; ?>
			<?php echo apply_filters('w2dc_create_option', $listing->level->name, $listing); ?>
			<?php
			if ($listing->listing_created && $listing->level->isUpgradable())
				echo '</a>';
			else
				echo '</b>'; ?>
		</span>
	</div>

	<?php if ($listing->listing_created): ?>
	<div class="misc-pub-section">
		<label for="post_level"><?php esc_html_e('Listing status', 'w2dc'); ?>:</label>
		<span id="post-level-display">
			<?php if ($listing->status == 'active'): ?>
			<span class="w2dc-badge w2dc-listing-status-active"><?php esc_html_e('active', 'w2dc'); ?></span>
			<?php elseif ($listing->status == 'expired'): ?>
			<span class="w2dc-badge w2dc-listing-status-expired"><?php esc_html_e('expired', 'w2dc'); ?></span><br />
			<a href="<?php echo admin_url('options.php?page=w2dc_renew&listing_id=' . $listing->post->ID); ?>"><span class="w2dc-fa w2dc-fa-refresh w2dc-fa-lg"></span> <?php echo apply_filters('w2dc_renew_option', esc_html__('renew listing', 'w2dc'), $listing); ?></a>
			<?php elseif ($listing->status == 'unpaid'): ?>
			<span class="w2dc-badge w2dc-listing-status-unpaid"><?php esc_html_e('unpaid ', 'w2dc'); ?></span>
			<?php elseif ($listing->status == 'stopped'): ?>
			<span class="w2dc-badge w2dc-listing-status-stopped"><?php esc_html_e('stopped', 'w2dc'); ?></span>
			<?php endif;?>
			<?php do_action('w2dc_listing_status_option', $listing); ?>
		</span>
		<?php if (!$listing->level->eternal_active_period && get_post_meta($listing->post->ID, '_preexpiration_notification_sent', true)): ?>
		<br />
		<?php esc_html_e('Pre-expiration notification was sent', 'w2dc'); ?>
		<?php endif; ?>
	</div>
	
	<?php
	$post_type_object = get_post_type_object(W2DC_POST_TYPE);
	$can_publish = current_user_can($post_type_object->cap->publish_posts);
	?>
	<?php if ($can_publish && $listing->status != 'active'): ?>
	<div class="misc-pub-section">
		<input name="w2dc_save_as_active" value="Save as Active" class="button" type="submit">
	</div>
	<?php endif; ?>

	<?php if (get_option('w2dc_enable_stats')): ?>
	<div class="misc-pub-section">
		<label for="post_level"><?php echo sprintf(esc_html__('Click stats: %d', 'w2dc'), (get_post_meta($w2dc_instance->current_listing->post->ID, '_total_clicks', true) ? get_post_meta($w2dc_instance->current_listing->post->ID, '_total_clicks', true) : 0)); ?></label>
	</div>
	<?php endif; ?>

	<div class="misc-pub-section curtime">
		<span id="timestamp">
			<?php esc_html_e('Sorting date', 'w2dc'); ?>:
			<b><?php echo w2dc_formatDateTime($listing->order_date); ?></b>
			<?php if ($listing->level->raiseup_enabled && $listing->status == 'active'): ?>
			<br />
			<a href="<?php echo admin_url('options.php?page=w2dc_raise_up&listing_id=' . $listing->post->ID); ?>"><span class="w2dc-fa w2dc-fa-level-up w2dc-fa-lg"></span> <?php echo apply_filters('w2dc_raiseup_option', esc_html__('raise up listing', 'w2dc'), $listing); ?></a>
			<?php endif; ?>
		</span>
	</div>

	<?php if ($listing->level->eternal_active_period || $listing->expiration_date): ?>
	<div class="misc-pub-section curtime">
		<span id="timestamp">
			<?php esc_html_e('Expire on', 'w2dc'); ?>:
			<?php if ($listing->level->eternal_active_period): ?>
			<b><?php esc_html_e('Eternal active period', 'w2dc'); ?></b>
			<?php else: ?>
			<b><?php echo w2dc_formatDateTime($listing->expiration_date); ?></b>
			<?php endif; ?>
		</span>
	</div>
	<?php endif; ?>
	
	<?php do_action('w2dc_listing_info_metabox_html', $listing); ?>

	<?php endif; ?>
</div>