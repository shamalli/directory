<?php

// @codingStandardsIgnoreFile

?>
<?php wcsearch_renderTemplate('admin_header.tpl.php'); ?>

<h2><?php esc_html_e('Demo Data Import'); ?></h2>

<?php if (!wcsearch_getValue($_POST, 'submit')): ?>
<div class="error">
	<p><?php esc_html_e("1. This is Demo Forms Import tool. This tool will help you to install some demo forms and demo pages.", "wcsearch"); ?></p>
	<p><?php esc_html_e("2. Each time you click import button - it creates new set of search forms and pages. Avoid duplicates.", "wcsearch"); ?></p>
	<p><?php esc_html_e("3. This is not 100% copy of the demo site. Just gives some examples of search forms. Final view and layout depends on your theme options.", "wcsearch"); ?></p>
</div>

<form method="POST" action="" id="demo_data_import_form">
	<?php wp_nonce_field(WCSEARCH_PATH, 'wcsearch_csv_import_nonce');?>
	
	<?php submit_button(esc_html__('Start import', 'wcsearch'), 'primary', 'submit', true, array('id' => 'import_button')); ?>
	
	<?php
	if (wcsearch_getValue($_GET, "export")) {
		submit_button(esc_html__('Export', 'wcsearch'), 'primary', 'export', true, array('id' => 'export_button'));
	}
	?>
</form>
<?php endif; ?>

<?php wcsearch_renderTemplate('admin_footer.tpl.php'); ?>