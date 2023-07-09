<?php w2rr_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php esc_html_e('Ratings & Reviews Reset', 'W2RR'); ?>
</h2>

<h3><?php esc_html_e('Are you sure you want to reset Ratings & Reviews?', 'W2RR'); ?></h3>
<a href="<?php echo admin_url('admin.php?page=w2rr_reset&reset=settings'); ?>"><?php esc_html_e('Reset settings', 'W2RR'); ?></a>
<br />
<a href="<?php echo admin_url('admin.php?page=w2rr_reset&reset=settings_tables'); ?>"><?php esc_html_e('Reset settings and database tables', 'W2RR'); ?></a>

<?php w2rr_renderTemplate('admin_footer.tpl.php'); ?>