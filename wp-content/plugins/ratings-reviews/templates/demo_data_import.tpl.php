<?php w2rr_renderTemplate('admin_header.tpl.php'); ?>

<h2><?php esc_html_e('Demo Data Import'); ?></h2>

<?php if (!empty($w2dc_reviews)): ?>
<div class="error">
	<p><?php printf(esc_html__("You have Web 2.0 Directory plugin with %d richtext review(s). Do you want to convert all reviews into Ratings & Reviews plugin?", "W2RR"), count($w2dc_reviews)); ?></p>
	
	<form method="POST" action="">
		<?php wp_nonce_field(W2RR_PATH, 'w2rr_csv_import_nonce');?>
	
		<?php submit_button(esc_html__('Import W2DC reviews', 'W2RR'), 'primary', 'submit_w2dc', true, array('id' => 'import_button')); ?>
	</form>
</div>
<?php endif; ?>

<?php if (!w2rr_getValue($_POST, 'submit')): ?>
<div class="error">
	<p><?php esc_html_e("1. This is Demo Data Import tool. This tool will help you to install some demo content reviews and sample pages.", "W2RR"); ?></p>
	<p><?php esc_html_e("2. Each time you click import button - it creates new set of reviews and pages. Avoid duplicates.", "W2RR"); ?></p>
	<p><?php esc_html_e("3. With activated WooCommerce plugin demo reviews will be created for some products of the shop.", "W2RR"); ?></p>
	<p><?php esc_html_e("4. Import will not add pages in your navigation menus.", "W2RR"); ?></p>
	<p><?php esc_html_e("5. This is not 100% copy of the demo site. Just gives some examples of the shortcodes usage. Final view and layout depends on your theme options.", "W2RR"); ?></p>
</div>

<form method="POST" action="" id="demo_data_import_form">
	<?php wp_nonce_field(W2RR_PATH, 'w2rr_csv_import_nonce');?>
	
	<?php submit_button(esc_html__('Start import', 'W2RR'), 'primary', 'submit', true, array('id' => 'import_button')); ?>
</form>
<?php endif; ?>

<?php w2rr_renderTemplate('admin_footer.tpl.php'); ?>