<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php esc_html_e('Listings directories', 'w2dc'); ?>
	<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . esc_html__('Create new directory', 'w2dc') . '</a>', $_GET['page'], 'add'); ?>
</h2>

<?php w2dc_esc_e('Create pages with following shortcodes. Each directory must have own page with its unique shortcode. <strong>All these pages are mandatory pages.</strong>', 'w2dc'); ?>

<form method="POST" action="<?php echo admin_url('admin.php?page=w2dc_directories'); ?>">
	<?php 
		$directories_table->display();
	?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>