<?php w2rr_renderTemplate('admin_header.tpl.php'); ?>

<h2><?php esc_html_e('CSV Import'); ?></h2>

<p class="description"><?php esc_html_e('On this second step collate CSV headers of columns with existing items fields', 'W2RR'); ?></p>

<form method="POST" action="">
	<input type="hidden" name="action" value="import_collate">
	<input type="hidden" name="import_type" value="<?php echo esc_attr($import_type); ?>">
	<input type="hidden" name="csv_file_name" value="<?php echo esc_attr($csv_file_name); ?>">
	<input type="hidden" name="images_dir" value="<?php echo esc_attr($images_dir); ?>">
	<input type="hidden" name="columns_separator" value="<?php echo esc_attr($columns_separator); ?>">
	<input type="hidden" name="values_separator" value="<?php echo esc_attr($values_separator); ?>">
	<?php wp_nonce_field(W2RR_PATH, 'w2rr_csv_import_nonce');?>
	
	<h3><?php esc_html_e('Map CSV columns', 'W2RR'); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<strong><?php esc_html_e('Column name', 'W2RR'); ?></strong>
					<hr />
				</th>
				<td>
					<strong><?php esc_html_e('Map to field', 'W2RR'); ?></strong>
					<hr />
				</td>
			</tr>
			<?php foreach ($headers AS $i=>$column): ?>
			<tr>
				<th scope="row">
					<label><?php echo esc_html($column); ?></label>
				</th>
				<td>
					<select name="fields[]">
						<option value=""><?php esc_html_e('- Select field -', 'W2RR'); ?></option>
						<?php foreach ($collation_fields AS $key=>$field): ?>
						<option value="<?php echo esc_attr($key); ?>" <?php if ($collated_fields) selected($collated_fields[$i], $key, true); ?>><?php echo esc_html($field); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<h3><?php esc_html_e('Import settings', 'W2RR'); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Author', 'W2RR'); ?></label>
				</th>
				<td>
					<select name="author">
						<option value="0" <?php isset($author) ? selected($author, 0) : selected(true); ?>><?php esc_html_e('As defined in CSV column'); ?></option>
						<?php foreach ($users AS $user): ?>
						<option value="<?php echo esc_attr($user->ID); ?>" <?php isset($author) ? selected($author, $user->ID) : ''; ?>><?php echo esc_html($user->user_login); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php w2rr_renderTemplate('csv_manager/import_instructions.tpl.php'); ?>
	
	<?php submit_button(esc_html__('Import', 'W2RR'), 'primary', 'submit', false); ?>
	&nbsp;&nbsp;&nbsp;
	<?php submit_button(esc_html__('Test import', 'W2RR'), 'secondary', 'tsubmit', false); ?>
</form>

<?php w2rr_renderTemplate('admin_footer.tpl.php'); ?>