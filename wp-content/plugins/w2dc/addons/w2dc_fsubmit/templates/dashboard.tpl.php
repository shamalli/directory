<div class="w2dc-content">
	<?php w2dc_renderMessages(); ?>

	<?php if (isset($directories)) $directories_buttons = $directories; else $directories_buttons = 'all'; ?>
	<?php $frontpanel_buttons = new w2dc_frontpanel_buttons(array('directories' => $directories_buttons, 'buttons' => 'submit,logout')); ?>
	<?php $frontpanel_buttons->display(); ?>

	<div class="w2dc-dashboard-tabs-content">
		<ul class="w2dc-dashboard-tabs w2dc-nav w2dc-nav-tabs w2dc-clearfix">
			<li <?php if ($frontend_controller->active_tab == 'listings') echo 'class="w2dc-active"'; ?>><a href="<?php echo w2dc_dashboardUrl(); ?>"><?php _e('Listings', 'W2DC'); ?> (<?php echo $frontend_controller->listings_count; ?>)</a></li>
			<?php if (get_option('w2dc_allow_edit_profile')): ?>
			<li <?php if ($frontend_controller->active_tab == 'profile') echo 'class="w2dc-active"'; ?>><a href="<?php echo w2dc_dashboardUrl(array('w2dc_action' => 'profile')); ?>"><?php _e('My profile', 'W2DC'); ?></a></li>
			<?php endif; ?>
			<?php do_action('w2dc_dashboard_links', $frontend_controller); ?>
		</ul>
	
		<div class="w2dc-tab-content w2dc-dashboard">
			<div class="w2dc-tab-pane w2dc-active">
				<?php w2dc_renderTemplate($frontend_controller->subtemplate, $frontend_controller->template_args); ?>
			</div>
		</div>
	</div>
</div>