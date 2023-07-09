	<?php if ($frontend_controller->listings): ?>
		<table class="w2dc-table w2dc-dashboard-listings w2dc-table-striped">
			<tr>
				<th class="w2dc-td-listing-id"><?php _e('ID', 'W2DC'); ?></th>
				<th class="w2dc-td-listing-title"><?php _e('Title', 'W2DC'); ?></th>
				<?php 
				// adapted for WPML
				global $sitepress;
				if (function_exists('wpml_object_id_filter') && $sitepress && get_option('w2dc_enable_frontend_translations') && ($languages = $sitepress->get_active_languages()) && count($languages) > 1): ?>
				<th class="w2dc-td-listing-translations">
					<?php foreach ($languages AS $lang_code=>$lang): ?>
					<?php if ($lang_code != ICL_LANGUAGE_CODE && apply_filters('wpml_object_id', $w2dc_instance->dashboard_page_id, 'page', false, $lang_code)): ?>
					<img src="<?php echo $sitepress->get_flag_url($lang_code); ?>" title="<?php esc_attr_e($lang['native_name']); ?>" />&nbsp;&nbsp;
					<?php endif; ?>
					<?php endforeach; ?>
				</th>
				<?php endif; ?>
				<th class="w2dc-td-listing-level"><?php _e('Level', 'W2DC'); ?><?php echo (($w2dc_instance->directories->isMultiDirectory()) ? '/' . __('Directory', 'W2DC') : ''); ?></th>
				<th class="w2dc-td-listing-status"><?php _e('Status', 'W2DC'); ?></th>
				<th class="w2dc-td-listing-expiration-date"><?php _e('Expiration date', 'W2DC'); ?></th>
				<th class="w2dc-td-listing-options"></th>
			</tr>
		<?php while ($frontend_controller->query->have_posts()): ?>
			<?php $frontend_controller->query->the_post(); ?>
			<?php $listing = $frontend_controller->listings[get_the_ID()]; ?>
			<tr>
				<td class="w2dc-td-listing-id"><?php echo $listing->post->ID; ?></td>
				<td class="w2dc-td-listing-title">
					<?php
					if (w2dc_current_user_can_edit_listing($listing->post->ID))
						echo '<a href="' . w2dc_get_edit_listing_link($listing->post->ID) . '">' . $listing->title() . '</a>';
					else
						echo $listing->title();
					do_action('w2dc_dashboard_listing_title', $listing);
					?>
					<?php if ($listing->post->post_status == 'pending') echo ' - ' . $listing->getPendingStatus(); ?>
					<?php if ($listing->post->post_status == 'draft') echo ' - ' . __('Draft or expired', 'W2DC'); ?>
					<?php if ($listing->claim && $listing->claim->isClaimed()) echo '<div>' . $listing->claim->getClaimMessage() . '</div>'; ?>
				</td>
				<?php 
				// adapted for WPML
				global $sitepress;
				if (function_exists('wpml_object_id_filter') && $sitepress && get_option('w2dc_enable_frontend_translations') && ($languages = $sitepress->get_active_languages()) && count($languages) > 1): ?>
				<td class="w2dc-td-listing-translations">
				<?php if (w2dc_current_user_can_edit_listing($listing->post->ID)):
					global $sitepress;
					$trid = $sitepress->get_element_trid($listing->post->ID, 'post_' . W2DC_POST_TYPE);
					$translations = $sitepress->get_element_translations($trid); ?>
					<?php foreach ($languages AS $lang_code=>$lang): ?>
					<?php if ($lang_code != ICL_LANGUAGE_CODE && apply_filters('wpml_object_id', $w2dc_instance->dashboard_page_id, 'page', false, $lang_code)): ?>
					<?php $lang_details = $sitepress->get_language_details($lang_code); ?>
					<?php do_action('wpml_switch_language', $lang_code); ?>
					<?php if (isset($translations[$lang_code])): ?>
					<a style="text-decoration:none" title="<?php echo sprintf(__('Edit the %s translation', 'sitepress'), $lang_details['display_name']); ?>" href="<?php echo add_query_arg(array('w2dc_action' => 'edit_listing', 'listing_id' => apply_filters('wpml_object_id', $listing->post->ID, W2DC_POST_TYPE, true, $lang_code)), get_permalink(apply_filters('wpml_object_id', $w2dc_instance->dashboard_page_id, 'page', true, $lang_code))); ?>">
						<img src="<?php echo ICL_PLUGIN_URL; ?>/res/img/edit_translation.png" alt="<?php esc_attr_e(__('edit translation', 'W2DC')); ?>" />
					</a>&nbsp;&nbsp;
					<?php else: ?>
					<a style="text-decoration:none" title="<?php echo sprintf(__('Add translation to %s', 'sitepress'), $lang_details['display_name']); ?>" href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'add_translation', 'listing_id' => $listing->post->ID, 'to_lang' => $lang_code)); ?>">
						<img src="<?php echo ICL_PLUGIN_URL; ?>/res/img/add_translation.png" alt="<?php esc_attr_e(__('add translation', 'W2DC')); ?>" />
					</a>&nbsp;&nbsp;
					<?php endif; ?>
					<?php endif; ?>
					<?php endforeach; ?>
					<?php do_action('wpml_switch_language', ICL_LANGUAGE_CODE); ?>
				<?php endif; ?>
				</td>
				<?php endif; ?>
				<td class="w2dc-td-listing-level">
					<?php if ($listing->level->isUpgradable())
						echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'upgrade_listing', 'listing_id' => $listing->post->ID)) . '" title="' . esc_attr__('Change level', 'W2DC') . '">'; ?>
					<?php echo $listing->level->name; ?>
					<?php if ($listing->level->isUpgradable())
						echo '<span class="w2dc-fa w2dc-fa-cog w2dc-fa-lg"></span></a>'; ?>
					<?php if ($w2dc_instance->directories->isMultiDirectory())
						echo '<br />' . $listing->directory->name;?>
				</td>
				<td class="w2dc-td-listing-status">
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
				</td>
				<td class="w2dc-td-listing-expiration-date">
					<?php
					if ($listing->level->eternal_active_period)
						_e('Eternal active period', 'W2DC');
					else
						echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->expiration_date));
					
					if ($listing->expiration_date > time())
						echo '<br />' . human_time_diff(time(), $listing->expiration_date) . '&nbsp;' . __('left', 'W2DC');
					?>
				</td>
				<td class="w2dc-td-listing-options">
					<div class="w2dc-btn-group">
						<?php if (w2dc_current_user_can_edit_listing($listing->post->ID)): ?>
						<a href="<?php echo w2dc_get_edit_listing_link($listing->post->ID); ?>" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-edit-btn" title="<?php esc_attr_e('edit listing', 'W2DC'); ?>"><span class="w2dc-glyphicon w2dc-glyphicon-edit"></span></a>
						<a href="<?php echo w2dc_get_edit_listing_link($listing->post->ID); ?>" class="w2dc-dashboard-btn-mobile"><?php _e('edit', 'W2DC'); ?></a>
						<?php endif; ?>
						<?php if (w2dc_current_user_can_delete_listing($listing->post->ID)): ?>
						<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'delete_listing', 'listing_id' => $listing->post->ID)); ?>" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-delete-btn" title="<?php esc_attr_e('delete listing', 'W2DC'); ?>"><span class="w2dc-glyphicon w2dc-glyphicon-trash"></span></a>
						<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'delete_listing', 'listing_id' => $listing->post->ID)); ?>" class="w2dc-dashboard-btn-mobile"><?php _e('delete', 'W2DC'); ?></a>
						<?php endif; ?>
						<?php if (w2dc_current_user_can_edit_listing($listing->post->ID)): ?>
						<?php
						if ($listing->level->raiseup_enabled && $listing->status == 'active' && $listing->post->post_status == 'publish') {
							$raise_up_link = strip_tags(apply_filters('w2dc_raiseup_option', __('raise up', 'W2DC'), $listing));
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'raiseup_listing', 'listing_id' => $listing->post->ID)) . '" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-raiseup-btn" title="' . esc_attr($raise_up_link) . '"><span class="w2dc-glyphicon w2dc-glyphicon-arrow-up"></span></a>';
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'raiseup_listing', 'listing_id' => $listing->post->ID)) . '" class="w2dc-dashboard-btn-mobile">' . $raise_up_link . '</a>';
						}?>
						<?php
						if ($listing->status == 'expired') {
							$renew_title = strip_tags(apply_filters('w2dc_renew_option', __('renew', 'W2DC'), $listing));
							$renew_link  = strip_tags(apply_filters('w2dc_renew_option_link', w2dc_dashboardUrl(array('w2dc_action' => 'renew_listing', 'listing_id' => $listing->post->ID)), $listing));
							echo '<a href="' . $renew_link . '" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-renew-btn" title="' . esc_attr($renew_title) . '"><span class="w2dc-glyphicon w2dc-glyphicon-refresh"></span></a>';
						}?>
						<?php
						if (get_option('w2dc_enable_stats')) {
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'view_stats', 'listing_id' => $listing->post->ID)) . '" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-stats-btn" title="' . esc_attr__('view clicks stats', 'W2DC') . '"><span class="w2dc-glyphicon w2dc-glyphicon-signal"></span></a>';
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'view_stats', 'listing_id' => $listing->post->ID)) . '" class="w2dc-dashboard-btn-mobile">' . __('stats', 'W2DC') . '</a>';
						}?>
						<?php
						if ($listing->status == 'active' && $listing->post->post_status == 'publish' && ($permalink = get_permalink($listing->post->ID))) {
							echo '<a href="' . $permalink . '" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-view-btn" title="' . esc_attr__('view listing', 'W2DC') . '"><span class="w2dc-glyphicon w2dc-glyphicon-link"></span></a>';
							echo '<a href="' . $permalink . '" class="w2dc-dashboard-btn-mobile">' . __('view', 'W2DC') . '</a>';
						}?>
						<?php endif; ?>
						<?php do_action('w2dc_dashboard_listing_options', $listing); ?>
					</div>
				</td>
			</tr>
		<?php endwhile; ?>
		</table>
		<?php w2dc_renderPaginator($frontend_controller->query, '', false); ?>
	<?php endif; ?>