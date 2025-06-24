<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php esc_html_e('Directory Reset', 'w2dc'); ?>
</h2>

<h3>Are you sure you want to reset directory?</h3>
<a href="<?php echo admin_url('admin.php?page=w2dc_reset&reset=installation'); ?>">Repeat installation</a>
<br />
<a href="<?php echo admin_url('admin.php?page=w2dc_reset&reset=settings'); ?>">Reset settings</a>
<br />
<a href="<?php echo admin_url('admin.php?page=w2dc_reset&reset=settings_tables'); ?>">Reset settings and database tables</a>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>