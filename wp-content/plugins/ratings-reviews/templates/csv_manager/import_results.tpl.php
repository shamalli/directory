<form method="POST" action="">
	<input type="hidden" name="action" value="import_settings">
	<input type="hidden" name="import_type" value="<?php echo esc_attr($import_type); ?>">
	<input type="hidden" name="csv_file_name" value="<?php echo esc_attr($csv_file_name); ?>">
	<input type="hidden" name="images_dir" value="<?php echo esc_attr($images_dir); ?>">
	<input type="hidden" name="columns_separator" value="<?php echo esc_attr($columns_separator); ?>">
	<input type="hidden" name="values_separator" value="<?php echo esc_attr($values_separator); ?>">
	<input type="hidden" name="author" value="<?php echo esc_attr($author); ?>">
	<?php foreach ($fields AS $field): ?>
	<input type="hidden" name="fields[]" value="<?php echo esc_attr($field); ?>">
	<?php endforeach; ?>
	<?php wp_nonce_field(W2RR_PATH, 'w2rr_csv_import_nonce');?>

	<?php if ($log['errors'] || $test_mode): ?>
	<?php submit_button(esc_html__('Go back', 'W2RR'), 'primary', 'goback', false); ?>
	&nbsp;&nbsp;&nbsp;
	<?php endif; ?>

	<a href="<?php echo admin_url('admin.php?page=w2rr_csv_import'); ?>" class="button button-primary"><?php esc_html_e('Import new file', 'W2RR'); ?></a>
</form>

<?php w2rr_renderTemplate('admin_footer.tpl.php'); ?>