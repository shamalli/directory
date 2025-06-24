<?php w2rr_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php esc_html_e('Ratings & Reviews Reset', 'w2rr'); ?>
</h2>

<h3><?php esc_html_e('Are you sure you want to reset Ratings & Reviews?', 'w2rr'); ?></h3>
<a href="<?php echo admin_url('admin.php?page=w2rr_reset&reset=settings'); ?>"><?php esc_html_e('Reset settings', 'w2rr'); ?></a>
<br />
<a href="<?php echo admin_url('admin.php?page=w2rr_reset&reset=settings_tables'); ?>"><?php esc_html_e('Reset settings and database tables', 'w2rr'); ?></a>

<?php w2rr_renderTemplate('admin_footer.tpl.php'); ?>