<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php
	if ($directory_id)
		esc_html_e('Edit directory', 'w2dc');
	else
		esc_html_e('Create new directory', 'w2dc');
	?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_directories_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Directory name', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="name"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($directory->name); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Single form', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="single"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($directory->single); ?>" />
					<?php w2dc_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Plural form', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="plural"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($directory->plural); ?>" />
					<?php w2dc_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php esc_html_e('Notice about slugs:', 'w2dc'); ?>
					<br />
					<?php esc_html_e('Slugs must contain only alpha-numeric characters, underscores or dashes. All slugs must be unique and different. Slugs must not match slugs of pages.', 'w2dc'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Listing slug', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="listing_slug"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($directory->listing_slug); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Category slug', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="category_slug"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($directory->category_slug); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Location slug', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="location_slug"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($directory->location_slug); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Tag slug', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="tag_slug"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($directory->tag_slug); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Assigned categories in the search', 'w2dc'); ?></label>
					<?php echo w2dc_get_wpml_dependent_option_description(); ?>
				</th>
				<td>
					<p class="description"><?php esc_html_e('You may define some special categories available for this directory', 'w2dc'); ?></p>
					<?php w2dc_termsSelectList('categories', W2DC_CATEGORIES_TAX, $directory->categories); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Assigned locations in the search', 'w2dc'); ?></label>
					<?php echo w2dc_get_wpml_dependent_option_description(); ?>
				</th>
				<td>
					<p class="description"><?php esc_html_e('You may define some special locations available for this directory', 'w2dc'); ?></p>
					<?php w2dc_termsSelectList('locations', W2DC_LOCATIONS_TAX, $directory->locations); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Listings levels', 'w2dc'); ?></label>
				</th>
				<td>
					<p class="description"><?php esc_html_e('You may define some special levels available for this directory', 'w2dc'); ?></p>
					<select multiple="multiple" name="levels[]" class="w2dc-form-control w2dc-form-group w2dc-height-300">
						<option value="" <?php if (!$directory->levels) echo 'selected'; ?>><?php esc_html_e('- Select All -', 'w2dc'); ?></option>
						<?php
						foreach ($w2dc_instance->levels->levels_array AS $level):
						?>
						<option value="<?php w2dc_esc_e($level->id); ?>" <?php if (in_array($level->id, $directory->levels)) echo 'selected'; ?>><?php w2dc_esc_e($level->name); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php
	if ($directory_id)
		submit_button(esc_html__('Save changes', 'w2dc'));
	else
		submit_button(esc_html__('Create directory', 'w2dc'));
	?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>