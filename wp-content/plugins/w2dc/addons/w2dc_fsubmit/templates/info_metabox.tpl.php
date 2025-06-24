<?php

// @codingStandardsIgnoreFile

$listing = $object;
?>
		<div class="w2dc-edit-listing-info w2dc-col-md-3">
			<div class="w2dc-submit-section">
				<h3 class="w2dc-submit-section-label"><?php esc_html_e('Listing info', 'w2dc'); ?></h3>
				<div class="w2dc-submit-section-inside">
					<?php if ($w2dc_instance->directories->isMultiDirectory()): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php esc_html_e('Listing directory', 'w2dc'); ?>:</label>
						<?php
						echo '<a href="' . $listing->directory->url . '">';
						w2dc_esc_e($listing->directory->name); ?>
						</a>
					</div>
					<?php endif; ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php esc_html_e('Listing level', 'w2dc'); ?>:</label>
						<?php
						if ($listing->listing_created && $listing->level->isUpgradable())
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'upgrade_listing', 'listing_id' => $listing->post->ID)) . '" title="' . esc_attr__('Change level', 'w2dc') . '">';
						else
							echo '<b>'; ?>
						<?php echo apply_filters('w2dc_create_option', $listing->level->name, $listing); ?>
						<?php
						if ($listing->listing_created && $listing->level->isUpgradable())
							echo '<span class="w2dc-fa w2dc-fa-cog w2dc-fa-lg"></span></a>';
						else
							echo '</b>'; ?>
					</div>
					<div class="w2dc-edit-listing-info-label">
						<label><?php esc_html_e('Listing status', 'w2dc'); ?>:</label>
						<?php
						if ($listing->status == 'active')
							echo '<span class="w2dc-badge w2dc-listing-status-active">' . esc_html__('active', 'w2dc') . '</span>';
						elseif ($listing->status == 'expired')
							echo '<span class="w2dc-badge w2dc-listing-status-expired">' . esc_html__('expired', 'w2dc') . '</span>';
						elseif ($listing->status == 'unpaid')
							echo '<span class="w2dc-badge w2dc-listing-status-unpaid">' . esc_html__('unpaid', 'w2dc') . '</span>';
						elseif ($listing->status == 'stopped')
							echo '<span class="w2dc-badge w2dc-listing-status-stopped">' . esc_html__('stopped', 'w2dc') . '</span>';
						do_action('w2dc_listing_status_option', $listing);
						?>
					</div>
					<?php if ($listing->post->post_status == 'pending' || $listing->post->post_status == 'draft'): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php esc_html_e('Post status', 'w2dc'); ?>:</label>
						<?php if ($listing->post->post_status == 'pending') echo $listing->getPendingStatus(); ?>
						<?php if ($listing->post->post_status == 'draft') echo  esc_html__('Draft or expired', 'w2dc'); ?>
					</div>
					<?php endif; ?>
					<?php if (get_option('w2dc_enable_stats')): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php echo sprintf(esc_html__('Click stats: %d', 'w2dc'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)); ?></label>
					</div>
					<?php endif; ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php esc_html_e('Sorting date', 'w2dc'); ?>:</label>
						<b><?php echo w2dc_formatDateTime($listing->order_date); ?></b>
						<?php if ($listing->level->raiseup_enabled && $listing->status == 'active'): ?>
						<br />
						<?php $raise_up_link = strip_tags(apply_filters('w2dc_raiseup_option', esc_html__('raise up', 'w2dc'), $listing)); ?>
						<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'raiseup_listing', 'listing_id' => $listing->post->ID)); ?>" title="<?php echo esc_attr($raise_up_link); ?>"><span class="w2dc-fa w2dc-fa-level-up w2dc-fa-lg"></span> <?php w2dc_esc_e($raise_up_link); ?></a>
						<?php endif; ?>
					</div>
					<?php if ($listing->status == 'active' || $listing->status == 'expired'): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php esc_html_e('Expire on', 'w2dc'); ?>:</label> 
						<?php if ($listing->level->eternal_active_period): ?>
						<b><?php esc_html_e('Eternal active period', 'w2dc'); ?></b>
						<?php else: ?>
						<b><?php echo w2dc_formatDateTime($listing->expiration_date); ?></b>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<?php if ($listing->status == 'active' && $listing->post->post_status == 'publish' && ($permalink = get_permalink($listing->post->ID))): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php esc_html_e('View listing', 'w2dc'); ?>:</label>
						<?php echo '<a href="' . $permalink . '" title="' . esc_attr__('view listing', 'w2dc') . '" target="_blank">' . $listing->title() . '</a>'; ?>
					</div>
					<?php endif; ?>
					<?php if ($listing->claim && $listing->claim->isClaimed()): ?>
					<div class="w2dc-edit-listing-info-label">
						<?php echo '<div>' . $listing->claim->getClaimMessage() . '</div>'; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>