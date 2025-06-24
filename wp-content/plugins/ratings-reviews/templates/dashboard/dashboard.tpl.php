<div class="w2rr-content">
	<?php w2rr_renderMessages(); ?>

	<a class="w2rr-logout-link w2rr-btn w2rr-btn-primary" href="<?php echo wp_logout_url(); ?>" rel="nofollow"><span class="w2rr-glyphicon w2rr-glyphicon-log-out"></span> <?php esc_html_e('Log out', 'w2rr'); ?></a>

	<div class="w2rr-dashboard-tabs-content">
		<ul class="w2rr-dashboard-tabs w2rr-nav w2rr-nav-tabs w2rr-clearfix">
			<li <?php if ($frontend_controller->active_tab == 'reviews') echo 'class="w2rr-active"'; ?>><a href="<?php echo w2rr_dashboardUrl(); ?>"><?php esc_html_e('Reviews', 'w2rr'); ?> (<?php echo w2rr_getReviewsCounterByAuthor(); ?>)</a></li>
			<?php if (get_option('w2rr_allow_edit_profile')): ?>
			<li <?php if ($frontend_controller->active_tab == 'profile') echo 'class="w2rr-active"'; ?>><a href="<?php echo w2rr_dashboardUrl(array('w2rr_action' => 'profile')); ?>"><?php esc_html_e('My profile', 'w2rr'); ?></a></li>
			<?php endif; ?>
			<?php do_action('w2rr_dashboard_links', $frontend_controller); ?>
		</ul>
	
		<div class="w2rr-tab-content w2rr-dashboard">
			<div class="w2rr-tab-pane w2rr-active">
				<?php w2rr_renderTemplate($frontend_controller->subtemplate, $frontend_controller->template_args); ?>
			</div>
		</div>
	</div>
</div>