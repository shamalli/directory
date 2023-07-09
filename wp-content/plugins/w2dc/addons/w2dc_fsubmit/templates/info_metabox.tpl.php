<?php $listing = $object; ?>
		<div class="w2dc-edit-listing-info w2dc-col-md-3">
			<div class="w2dc-submit-section">
				<h3 class="w2dc-submit-section-label"><?php _e('Listing info', 'W2DC'); ?></h3>
				<div class="w2dc-submit-section-inside">
					<?php if ($w2dc_instance->directories->isMultiDirectory()): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php _e('Listing directory', 'W2DC'); ?>:</label>
						<?php
						echo '<a href="' . $listing->directory->url . '">';
						echo $listing->directory->name; ?>
						</a>
					</div>
					<?php endif; ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php _e('Listing level', 'W2DC'); ?>:</label>
						<?php
						if ($listing->listing_created && $listing->level->isUpgradable())
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'upgrade_listing', 'listing_id' => $listing->post->ID)) . '" title="' . esc_attr__('Change level', 'W2DC') . '">';
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
						<label><?php _e('Listing status', 'W2DC'); ?>:</label>
						<?php
						if ($listing->status == 'active')
							echo '<span class="w2dc-badge w2dc-listing-status-active">' . __('active', 'W2DC') . '</span>';
						elseif ($listing->status == 'expired')
							echo '<span class="w2dc-badge w2dc-listing-status-expired">' . __('expired', 'W2DC') . '</span>';
						elseif ($listing->status == 'unpaid')
							echo '<span class="w2dc-badge w2dc-listing-status-unpaid">' . __('unpaid', 'W2DC') . '</span>';
						elseif ($listing->status == 'stopped')
							echo '<span class="w2dc-badge w2dc-listing-status-stopped">' . __('stopped', 'W2DC') . '</span>';
						do_action('w2dc_listing_status_option', $listing);
						?>
					</div>
					<?php if ($listing->post->post_status == 'pending' || $listing->post->post_status == 'draft'): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php _e('Post status', 'W2DC'); ?>:</label>
						<?php if ($listing->post->post_status == 'pending') echo $listing->getPendingStatus(); ?>
						<?php if ($listing->post->post_status == 'draft') echo  __('Draft or expired', 'W2DC'); ?>
					</div>
					<?php endif; ?>
					<?php if (get_option('w2dc_enable_stats')): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php echo sprintf(__('Click stats: %d', 'W2DC'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)); ?></label>
					</div>
					<?php endif; ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php _e('Sorting date', 'W2DC'); ?>:</label>
						<b><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->order_date)); ?></b>
						<?php if ($listing->level->raiseup_enabled && $listing->status == 'active'): ?>
						<br />
						<?php $raise_up_link = strip_tags(apply_filters('w2dc_raiseup_option', __('raise up', 'W2DC'), $listing)); ?>
						<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'raiseup_listing', 'listing_id' => $listing->post->ID)); ?>" title="<?php echo esc_attr($raise_up_link); ?>"><span class="w2dc-fa w2dc-fa-level-up w2dc-fa-lg"></span> <?php echo $raise_up_link; ?></a>
						<?php endif; ?>
					</div>
					<?php if ($listing->status == 'active' || $listing->status == 'expired'): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php _e('Expire on', 'W2DC'); ?>:</label> 
						<?php if ($listing->level->eternal_active_period): ?>
						<b><?php _e('Eternal active period', 'W2DC'); ?></b>
						<?php else: ?>
						<b><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->expiration_date)); ?></b>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<?php if ($listing->status == 'active' && $listing->post->post_status == 'publish' && ($permalink = get_permalink($listing->post->ID))): ?>
					<div class="w2dc-edit-listing-info-label">
						<label><?php _e('View listing', 'W2DC'); ?>:</label>
						<?php echo '<a href="' . $permalink . '" title="' . esc_attr__('view listing', 'W2DC') . '" target="_blank">' . $listing->title() . '</a>'; ?>
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