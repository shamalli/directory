<?php

// @codingStandardsIgnoreFile

?>
	<?php if ($frontend_controller->listings): ?>
		<table class="w2dc-table w2dc-dashboard-listings w2dc-table-striped">
			<tr>
				<th class="w2dc-td-listing-id"><?php esc_html_e('ID', 'w2dc'); ?></th>
				<th class="w2dc-td-listing-title"><?php esc_html_e('Title', 'w2dc'); ?></th>
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
				<th class="w2dc-td-listing-level"><?php esc_html_e('Level', 'w2dc'); ?><?php echo (($w2dc_instance->directories->isMultiDirectory()) ? '/' . esc_html__('Directory', 'w2dc') : ''); ?></th>
				<th class="w2dc-td-listing-status"><?php esc_html_e('Status', 'w2dc'); ?></th>
				<th class="w2dc-td-listing-expiration-date"><?php esc_html_e('Expiration date', 'w2dc'); ?></th>
				<th class="w2dc-td-listing-options"></th>
			</tr>
		<?php while ($frontend_controller->query->have_posts()): ?>
			<?php $frontend_controller->query->the_post(); ?>
			<?php $listing = $frontend_controller->listings[get_the_ID()]; ?>
			<tr>
				<td class="w2dc-td-listing-id"><?php w2dc_esc_e($listing->post->ID); ?></td>
				<td class="w2dc-td-listing-title">
					<?php
					if (w2dc_current_user_can_edit_listing($listing->post->ID))
						echo '<a href="' . w2dc_get_edit_listing_link($listing->post->ID) . '">' . $listing->title() . '</a>';
					else
						echo $listing->title();
					do_action('w2dc_dashboard_listing_title', $listing);
					?>
					<?php if ($listing->post->post_status == 'pending') echo ' - ' . $listing->getPendingStatus(); ?>
					<?php if ($listing->post->post_status == 'draft') echo ' - ' . esc_html__('Draft or expired', 'w2dc'); ?>
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
					<a title="<?php echo sprintf(esc_html__('Edit the %s translation', 'sitepress'), $lang_details['display_name']); ?>" href="<?php echo add_query_arg(array('w2dc_action' => 'edit_listing', 'listing_id' => apply_filters('wpml_object_id', $listing->post->ID, W2DC_POST_TYPE, true, $lang_code)), get_permalink(apply_filters('wpml_object_id', $w2dc_instance->dashboard_page_id, 'page', true, $lang_code))); ?>">
						<img src="<?php echo ICL_PLUGIN_URL; ?>/res/img/edit_translation.png" alt="<?php esc_attr_e('edit translation', 'w2dc'); ?>" />
					</a>&nbsp;&nbsp;
					<?php else: ?>
					<a title="<?php echo sprintf(esc_html__('Add translation to %s', 'sitepress'), $lang_details['display_name']); ?>" href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'add_translation', 'listing_id' => $listing->post->ID, 'to_lang' => $lang_code)); ?>">
						<img src="<?php echo ICL_PLUGIN_URL; ?>/res/img/add_translation.png" alt="<?php esc_attr_e('add translation', 'w2dc'); ?>" />
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
						echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'upgrade_listing', 'listing_id' => $listing->post->ID)) . '" title="' . esc_attr__('Change level', 'w2dc') . '">'; ?>
					<?php w2dc_esc_e($listing->level->name); ?>
					<?php if ($listing->level->isUpgradable())
						echo '<span class="w2dc-fa w2dc-fa-cog w2dc-fa-lg"></span></a>'; ?>
					<?php if ($w2dc_instance->directories->isMultiDirectory())
						echo '<br />' . $listing->directory->name;?>
				</td>
				<td class="w2dc-td-listing-status">
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
				</td>
				<td class="w2dc-td-listing-expiration-date">
					<?php
					if ($listing->level->eternal_active_period)
						esc_html_e('Eternal active period', 'w2dc');
					else
						echo w2dc_formatDateTime($listing->expiration_date);
					
					if ($listing->expiration_date > time())
						echo '<br />' . human_time_diff(time(), $listing->expiration_date) . '&nbsp;' . esc_html__('left', 'w2dc');
					?>
				</td>
				<td class="w2dc-td-listing-options">
					<div class="w2dc-btn-group">
						<?php if (w2dc_current_user_can_edit_listing($listing->post->ID)): ?>
						<a href="<?php echo w2dc_get_edit_listing_link($listing->post->ID); ?>" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-edit-btn" title="<?php esc_attr_e('edit listing', 'w2dc'); ?>"><span class="w2dc-glyphicon w2dc-glyphicon-edit"></span></a>
						<a href="<?php echo w2dc_get_edit_listing_link($listing->post->ID); ?>" class="w2dc-dashboard-btn-mobile"><?php esc_html_e('edit', 'w2dc'); ?></a>
						<?php endif; ?>
						<?php if (w2dc_current_user_can_delete_listing($listing->post->ID)): ?>
						<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'delete_listing', 'listing_id' => $listing->post->ID)); ?>" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-delete-btn" title="<?php esc_attr_e('delete listing', 'w2dc'); ?>"><span class="w2dc-glyphicon w2dc-glyphicon-trash"></span></a>
						<a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'delete_listing', 'listing_id' => $listing->post->ID)); ?>" class="w2dc-dashboard-btn-mobile"><?php esc_html_e('delete', 'w2dc'); ?></a>
						<?php endif; ?>
						<?php if (w2dc_current_user_can_edit_listing($listing->post->ID)): ?>
						<?php
						if ($listing->level->raiseup_enabled && $listing->status == 'active' && $listing->post->post_status == 'publish') {
							$raise_up_link = strip_tags(apply_filters('w2dc_raiseup_option', esc_html__('raise up', 'w2dc'), $listing));
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'raiseup_listing', 'listing_id' => $listing->post->ID)) . '" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-raiseup-btn" title="' . esc_attr($raise_up_link) . '"><span class="w2dc-glyphicon w2dc-glyphicon-arrow-up"></span></a>';
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'raiseup_listing', 'listing_id' => $listing->post->ID)) . '" class="w2dc-dashboard-btn-mobile">' . $raise_up_link . '</a>';
						}?>
						<?php
						if ($listing->status == 'expired') {
							$renew_title = strip_tags(apply_filters('w2dc_renew_option', esc_html__('renew', 'w2dc'), $listing));
							$renew_link  = strip_tags(apply_filters('w2dc_renew_option_link', w2dc_dashboardUrl(array('w2dc_action' => 'renew_listing', 'listing_id' => $listing->post->ID)), $listing));
							echo '<a href="' . $renew_link . '" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-renew-btn" title="' . esc_attr($renew_title) . '"><span class="w2dc-glyphicon w2dc-glyphicon-refresh"></span></a>';
						}?>
						<?php
						if (get_option('w2dc_enable_stats')) {
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'view_stats', 'listing_id' => $listing->post->ID)) . '" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-stats-btn" title="' . esc_attr__('view clicks stats', 'w2dc') . '"><span class="w2dc-glyphicon w2dc-glyphicon-signal"></span></a>';
							echo '<a href="' . w2dc_dashboardUrl(array('w2dc_action' => 'view_stats', 'listing_id' => $listing->post->ID)) . '" class="w2dc-dashboard-btn-mobile">' . esc_html__('stats', 'w2dc') . '</a>';
						}?>
						<?php
						if ($listing->status == 'active' && $listing->post->post_status == 'publish' && ($permalink = get_permalink($listing->post->ID))) {
							echo '<a href="' . $permalink . '" class="w2dc-btn w2dc-btn-primary w2dc-btn-sm w2dc-dashboard-view-btn" title="' . esc_attr__('view listing', 'w2dc') . '"><span class="w2dc-glyphicon w2dc-glyphicon-link"></span></a>';
							echo '<a href="' . $permalink . '" class="w2dc-dashboard-btn-mobile">' . esc_html__('view', 'w2dc') . '</a>';
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