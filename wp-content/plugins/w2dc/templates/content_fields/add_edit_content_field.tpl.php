<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php
	if ($field_id)
		esc_html_e('Edit content field', 'w2dc');
	else
		esc_html_e('Create new content field', 'w2dc');
	?>
</h2>
<?php
if ($field_id && $content_field->isConfigurationPage())
	printf('<a href="?page=%s&action=%s&field_id=%d">' . esc_html__('Configure', 'w2dc') . '</a>', $_GET['page'], 'configure', $field_id);
?>

<?php if ($content_field->is_core_field): ?>
<p class="description"><?php esc_attr_e("You can't select assigned categories for core fields such as content, excerpt, categories, tags and addresses", 'w2dc'); ?></p>
<?php endif; ?>

<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#content_field_name").keyup(function() {
				$("#content_field_slug").val(w2dc_make_slug($("#content_field_name").val()));
			});
	
			<?php if (!$content_field->is_core_field): ?>
			$("#type").change(function() {
				if (
					<?php
					foreach ($content_fields->fields_types_names AS $content_field_type=>$content_field_name){
						$field_class_name = 'w2dc_content_field_' . $content_field_type;
						if (class_exists($field_class_name)) {
							$_content_field = new $field_class_name;
							if (!$_content_field->canBeOrdered()) {
					?>
					$(this).val() == '<?php w2dc_esc_e($content_field_type); ?>' ||
					<?php
							}
						}
					} ?>
				'x'=='y')
					$("#is_ordered_block").hide();
				else
					$("#is_ordered_block").show();
	
				if (
					<?php
					foreach ($content_fields->fields_types_names AS $content_field_type=>$content_field_name){
						$field_class_name = 'w2dc_content_field_' . $content_field_type;
						if (class_exists($field_class_name)) {
							$_content_field = new $field_class_name;
							if (!$_content_field->canBeRequired()) {
					?>
					$(this).val() == '<?php w2dc_esc_e($content_field_type); ?>' ||
					<?php
							}
						}
					} ?>
				'x'=='y')
					$("#is_required_block").hide();
				else
					$("#is_required_block").show();
			});
			<?php endif; ?>
		});
	})(jQuery);
</script>

<form method="POST" action="">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Field name', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="name"
						id="content_field_name"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->name); ?>" />
					<?php w2dc_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<?php if ($content_field->isSlug()) :?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Field slug', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="slug"
						id="content_field_slug"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->slug); ?>" />
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Hide name', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="is_hide_name"
						type="checkbox"
						value="1"
						<?php checked($content_field->is_hide_name); ?> />
					<p class="description"><?php esc_html_e("Hide field name at the frontend? Only icon will be shown.", 'w2dc'); ?></p>
				</td>
			</tr>
			<?php if (!$content_field->is_core_field): ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Only admins can see what was entered', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="for_admin_only"
						type="checkbox"
						value="1"
						<?php checked($content_field->for_admin_only); ?> />
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Field description', 'w2dc'); ?></label>
				</th>
				<td>
					<textarea
						name="description"
						cols="60"
						rows="4" ><?php echo esc_textarea($content_field->description); ?></textarea>
					<?php w2dc_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Icon image', 'w2dc'); ?></label>
				</th>
				<td>
					<span class="w2dc-icon-tag <?php if ($content_field->icon_image): ?>w2dc-fa <?php w2dc_esc_e($content_field->icon_image); ?><?php endif; ?>" <?php if (!$content_field->icon_image): ?>style="display: none;"<?php endif; ?>></span>
					<input type="hidden" name="icon_image" id="w2dc-icon-image" value="<?php if (!is_numeric($content_field->icon_image)) echo esc_attr($content_field->icon_image); ?>">
					<div>
						<a class="w2dc-select-fa-icon" href="javascript: void(0);" data-icon-tag="w2dc-icon-tag" data-icon-image-name="w2dc-icon-image"><?php echo esc_js(esc_html__('Select field icon', 'w2dc')); ?></a>
					</div>
					<br />
					<br />
					<p class="description"><?php esc_html_e('upload icon image', 'w2dc'); ?></p>
					<?php $upload_icon->display_form(); ?>
				</td>
			</tr>
			
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Field type', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<select name="type" id="type" <?php disabled($content_field->is_core_field); ?>>
						<option value=""><?php esc_html_e('- Select field type -', 'w2dc'); ?></option>
						<?php if ($content_field->is_core_field) :?>
						<option value="excerpt" <?php selected($content_field->type, 'excerpt'); ?> ><?php w2dc_esc_e($fields_types_names['excerpt']); ?></option>
						<option value="content" <?php selected($content_field->type, 'content'); ?> ><?php w2dc_esc_e($fields_types_names['content']); ?></option>
						<option value="categories" <?php selected($content_field->type, 'categories'); ?> ><?php w2dc_esc_e($fields_types_names['categories']); ?></option>
						<option value="tags" <?php selected($content_field->type, 'tags'); ?> ><?php w2dc_esc_e($fields_types_names['tags']); ?></option>
						<option value="address" <?php selected($content_field->type, 'address'); ?> ><?php w2dc_esc_e($fields_types_names['address']); ?></option>
						<?php endif; ?>
						<option value="string" <?php selected($content_field->type, 'string'); ?> ><?php w2dc_esc_e($fields_types_names['string']); ?></option>
						<option value="phone" <?php selected($content_field->type, 'phone'); ?> ><?php w2dc_esc_e($fields_types_names['phone']); ?></option>
						<option value="textarea" <?php selected($content_field->type, 'textarea'); ?> ><?php w2dc_esc_e($fields_types_names['textarea']); ?></option>
						<option value="number" <?php selected($content_field->type, 'number'); ?> ><?php w2dc_esc_e($fields_types_names['number']); ?></option>
						<option value="select" <?php selected($content_field->type, 'select'); ?> ><?php w2dc_esc_e($fields_types_names['select']); ?></option>
						<option value="radio" <?php selected($content_field->type, 'radio'); ?> ><?php w2dc_esc_e($fields_types_names['radio']); ?></option>
						<option value="checkbox" <?php selected($content_field->type, 'checkbox'); ?> ><?php w2dc_esc_e($fields_types_names['checkbox']); ?></option>
						<option value="website" <?php selected($content_field->type, 'website'); ?> ><?php w2dc_esc_e($fields_types_names['website']); ?></option>
						<option value="email" <?php selected($content_field->type, 'email'); ?> ><?php w2dc_esc_e($fields_types_names['email']); ?></option>
						<option value="datetime" <?php selected($content_field->type, 'datetime'); ?> ><?php w2dc_esc_e($fields_types_names['datetime']); ?></option>
						<option value="price" <?php selected($content_field->type, 'price'); ?> ><?php w2dc_esc_e($fields_types_names['price']); ?></option>
						<option value="hours" <?php selected($content_field->type, 'hours'); ?> ><?php w2dc_esc_e($fields_types_names['hours']); ?></option>
						<option value="fileupload" <?php selected($content_field->type, 'fileupload'); ?> ><?php w2dc_esc_e($fields_types_names['fileupload']); ?></option>
					</select>
					<?php if ($content_field->is_core_field): ?>
					<p class="description"><?php esc_attr_e("You can't change the type of core fields", 'w2dc'); ?></p>
					<?php endif; ?>
				</td>
			</tr>

			<tr id="is_required_block" <?php if (!$content_field->canBeRequired()): ?>style="display: none;"<?php endif; ?>>
				<th scope="row">
					<label><?php esc_html_e('Is this field required?', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="is_required"
						type="checkbox"
						value="1"
						<?php checked($content_field->is_required); ?> />
				</td>
			</tr>
			<tr id="is_ordered_block" <?php if (!$content_field->canBeOrdered()): ?>style="display: none;"<?php endif; ?>>
				<th scope="row">
					<label><?php esc_html_e('Order by field', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="is_ordered"
						type="checkbox"
						value="1"
						<?php checked($content_field->is_ordered); ?> />
					<p class="description"><?php esc_html_e("It is possible to order listings by this field", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('On excerpt pages', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="on_exerpt_page"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_exerpt_page); ?> />
					<p class="description"><?php esc_html_e("Show on index, categories, locations, tags, search results pages", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('On listing pages', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="on_listing_page"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_listing_page); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('In map marker InfoWindow', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="on_map"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_map); ?> />
				</td>
			</tr>
			
			<script>
				(function($) {
					"use strict";
	
					$(function() {
						<?php if (!$content_field->is_core_field): ?>
						$("#type").change(function() {
							if (
								<?php 
								foreach ($content_fields->fields_types_names AS $content_field_type=>$content_field_name){
									$field_class_name = 'w2dc_content_field_' . $content_field_type;
									if (class_exists($field_class_name)) {
										$_content_field = new $field_class_name;
										if (!$_content_field->canBeSearched()) {
								?>
								$(this).val() == '<?php w2dc_esc_e($content_field_type); ?>' ||
								<?php
										}
									}
								} ?>
							$(this).val() === '')
								$(".can_be_searched_block").hide();
							else
								$(".can_be_searched_block").show();
						});
						<?php endif; ?>
					});
				})(jQuery);
			</script>
			<tr class="can_be_searched_block" <?php if (!$content_field->canBeSearched()): ?>style="display: none;"<?php endif; ?>>
				<th scope="row">
					<label><?php esc_html_e('Search by this field', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						id="on_search_form"
						name="on_search_form"
						type="checkbox"
						value="1"
						<?php checked($content_field->on_search_form); ?> />
					<p class="description"><?php esc_html_e("Allow this field to work in search and shortcodes. Or the field will not action on search form.", 'w2dc'); ?></p>
				</td>
			</tr>
			
			<?php do_action('w2dc_content_field_html', $content_field); ?>
			
			<?php if ($content_field->isCategories()): ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Assigned categories', 'w2dc'); ?></label>
					<p class="description"><?php esc_html_e("This field will be dependent from selected categories.", 'w2dc'); ?></p>
					<?php echo w2dc_get_wpml_dependent_option_description(); ?>
				</th>
				<td>
					<?php w2dc_termsSelectList('categories', W2DC_CATEGORIES_TAX, $content_field->categories); ?>
				</td>
			</tr>
			<?php endif; ?>
			
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Listings levels', 'w2dc'); ?></label>
				</th>
				<td>
					<p class="description"><?php esc_html_e('You may define some special levels, this field will be visible only in selected levels', 'w2dc'); ?></p>
					<select multiple="multiple" name="levels[]" class="w2dc-form-control w2dc-form-group w2dc-height-300">
						<?php
						foreach ($w2dc_instance->levels->levels_array AS $level):
						// select only level with all content fields, or with currently selected field
						?>
						<option value="<?php w2dc_esc_e($level->id); ?>" <?php if (empty($level->content_fields) || in_array($content_field->id, $level->content_fields) || in_array($level->id, $content_field->levels)) echo 'selected'; ?>><?php w2dc_esc_e($level->name); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			
		</tbody>
	</table>
	
	<?php
	if ($field_id)
		submit_button(esc_html__('Save changes', 'w2dc'));
	else
		submit_button(esc_html__('Create content field', 'w2dc'));
	?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>