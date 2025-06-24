<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2><?php esc_html_e('CSV Import'); ?></h2>

<p class="description"><?php esc_html_e('On this second step collate CSV headers of columns with existing items fields', 'w2dc'); ?></p>

<form method="POST" action="">
	<input type="hidden" name="action" value="import_collate">
	<input type="hidden" name="import_type" value="<?php echo esc_attr($import_type); ?>">
	<input type="hidden" name="csv_file_name" value="<?php echo esc_attr($csv_file_name); ?>">
	<input type="hidden" name="images_dir" value="<?php echo esc_attr($images_dir); ?>">
	<input type="hidden" name="columns_separator" value="<?php echo esc_attr($columns_separator); ?>">
	<input type="hidden" name="values_separator" value="<?php echo esc_attr($values_separator); ?>">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_csv_import_nonce');?>
	
	<h3><?php esc_html_e('Map CSV columns', 'w2dc'); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<strong><?php esc_html_e('Column name', 'w2dc'); ?></strong>
					<hr />
				</th>
				<td>
					<strong><?php esc_html_e('Map to field', 'w2dc'); ?></strong>
					<hr />
				</td>
			</tr>
			<?php foreach ($headers AS $i=>$column): ?>
			<tr>
				<th scope="row">
					<label><?php w2dc_esc_e($column); ?></label>
				</th>
				<td>
					<select name="fields[]">
						<option value=""><?php esc_html_e('- Select field -', 'w2dc'); ?></option>
						<?php foreach ($collation_fields AS $key=>$field): ?>
						<option value="<?php w2dc_esc_e($key); ?>" <?php if ($collated_fields) selected($collated_fields[$i], $key, true); ?>><?php w2dc_esc_e($field); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<h3><?php esc_html_e('Import settings', 'w2dc'); ?></h3>
	<table class="form-table">
		<tbody>
			<?php if ($import_type == 'create_listings' || $import_type == 'update_listings'): ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('What to do when category/location/tag was not found', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="if_term_not_found"
						type="radio"
						value="create"
						<?php isset($if_term_not_found) ? checked($if_term_not_found, 'create') : checked(true); ?> />
					<?php esc_html_e('Create new category/location/tag', 'w2dc'); ?>

					<br />

					<input
						name="if_term_not_found"
						type="radio"
						value="skip"
						<?php isset($if_term_not_found) ? checked($if_term_not_found, 'skip') : ''; ?> />
					<?php esc_html_e('Do not do anything', 'w2dc'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Geocode imported listings by address parts', 'w2dc'); ?></label>
					<p class="description">
						<?php esc_html_e("Required when you don't have coordinates to import, but need listings map markers.", 'w2dc'); ?>
						<?php printf(wp_kses(__('Maps API key must be working! Check geolocation <a href="%s">response</a>.', 'w2dc'), 'post'), admin_url('admin.php?page=w2dc_debug')); ?>
					</p>
				</th>
				<td>
					<input
						name="do_geocode"
						type="checkbox"
						value="1"
						<?php checked($do_geocode, 1, true); ?> />
				</td>
			</tr>
			<?php if (get_option('w2dc_fsubmit_addon') && get_option('w2dc_claim_functionality')): ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Configure imported listings as claimable', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="is_claimable"
						type="checkbox"
						value="1"
						<?php checked($is_claimable, 1, true); ?> />
				</td>
			</tr>
			<?php endif; ?>
			<?php endif; ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Author', 'w2dc'); ?></label>
				</th>
				<td>
					<select name="author">
						<option value="0" <?php isset($author) ? selected($author, 0) : selected(true); ?>><?php esc_html_e('As defined in CSV column'); ?></option>
						<?php foreach ($users AS $user): ?>
						<option value="<?php w2dc_esc_e($user->ID); ?>" <?php isset($author) ? selected($author, $user->ID) : ''; ?>><?php w2dc_esc_e($user->user_login); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php w2dc_renderTemplate('csv_manager/import_instructions.tpl.php'); ?>
	
	<?php submit_button(esc_html__('Import', 'w2dc'), 'primary', 'submit', false); ?>
	&nbsp;&nbsp;&nbsp;
	<?php submit_button(esc_html__('Test import', 'w2dc'), 'secondary', 'tsubmit', false); ?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>