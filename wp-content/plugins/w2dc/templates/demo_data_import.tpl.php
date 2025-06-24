<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2><?php esc_html_e('Demo Data Import'); ?></h2>

<?php if (!w2dc_getValue($_POST, 'submit')): ?>
<div class="error">
	<p><?php esc_html_e("1. This is Demo Data Import tool. This tool will help you to install some demo content, such as listings, search forms, custom home pages and pages with examples of the shortcodes usage.", "w2dc"); ?></p>
	<p><?php esc_html_e("2. Each time you click import button - it creates new set of listings and pages. Avoid duplicates.", "w2dc"); ?></p>
	<p><?php esc_html_e("3. Import will not add pages in your navigation menus.", "w2dc"); ?></p>
	<p><?php esc_html_e("4. This is not 100% copy of the demo site. Just gives some examples of the shortcodes usage. Final view and layout depends on your theme options.", "w2dc"); ?></p>
	<p><?php esc_html_e("5. Web 2.0 Directory page with [webdirectory] shortcode is mandatory. Listing Single Template page quite recommended [webdirectory-listing-page]. Others you can delete.", "w2dc"); ?></p>
</div>

<form method="POST" action="" id="demo_data_import_form">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_csv_import_nonce');?>
	
	<?php submit_button(esc_html__('Start import', 'w2dc'), 'primary', 'submit', true, array('id' => 'import_button')); ?>
	
	<?php
	if (w2dc_getValue($_GET, "export")) {
		submit_button(esc_html__('Export', 'w2dc'), 'primary', 'export', true, array('id' => 'export_button'));
	}
	?>
</form>
<?php endif; ?>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>