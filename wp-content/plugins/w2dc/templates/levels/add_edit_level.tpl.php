<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php
	if ($level_id)
		esc_html_e('Edit level', 'w2dc');
	else
		esc_html_e('Create new level', 'w2dc');
	?>
</h2>

<script>
(function($) {
	"use strict";

	$(function() {
		$("body").on("click", "#eternal_active_period", function() {
			if ($('#eternal_active_period').is(':checked')) {
				$('#active_interval').attr('disabled', true);
				$('#active_period').attr('disabled', true);
				$('#change_level_id').attr('disabled', true);
		    } else {
		    	$('#active_interval').removeAttr('disabled');
		    	$('#active_period').removeAttr('disabled');
		    	$('#change_level_id').removeAttr('disabled');
		    }
		});
	
		$("body").on("click", "#unlimited_categories", function() {
			if ($("#unlimited_categories").is(':checked')) {
				$("#categories_number").attr('disabled', true);
			} else {
				$("#categories_number").removeAttr('disabled');
			}
		});
		
		$("body").on("click", "#unlimited_tags", function() {
			if ($("#unlimited_tags").is(':checked')) {
				$("#tags_number").attr('disabled', true);
			} else {
				$("#tags_number").removeAttr('disabled');
			}
		});
	});
})(jQuery);
</script>

<form method="POST" action="">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_levels_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Level name', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="name"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($level->name); ?>" />
					<?php w2dc_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Level description', 'w2dc'); ?></label>
				</th>
				<td>
					<textarea
						name="description"
						cols="60"
						rows="4" ><?php echo esc_textarea($level->description); ?></textarea>
					<p class="description"><?php esc_html_e("Describe this level's advantages and options as much easier for users as you can", 'w2dc'); ?></p>
					<?php w2dc_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Who can view listings', 'w2dc'); ?></label>
				</th>
				<td>
					<select multiple="multiple" name="who_can_view[]" class="w2dc-form-control w2dc-form-group w2dc-height-300">
						<option value="" <?php echo ((!$level->who_can_view) ? 'selected' : ''); ?>><?php esc_html_e("Any users", "w2dc"); ?></option>
						<option value="loggedinusers" <?php echo ((in_array('loggedinusers', $level->who_can_view)) ? 'selected' : ''); ?>><?php esc_html_e("Any logged in users", "w2dc"); ?></option>
						<?php foreach (get_editable_roles() as $role_name => $role_info): ?>
						<option value="<?php w2dc_esc_e($role_name); ?>" <?php echo ((in_array($role_name, $level->who_can_view)) ? 'selected' : ''); ?>><?php w2dc_esc_e($role_info['name']); ?></option>
						<?php endforeach; ?>
					</select>
					<p class="description"><?php esc_html_e("Specify what users can see listings in this level: any users, only logged in users, or select specific users groups.", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Who can submit listings', 'w2dc'); ?></label>
				</th>
				<td>
					<select multiple="multiple" name="who_can_submit[]" class="w2dc-form-control w2dc-form-group w2dc-height-300">
						<option value="" <?php echo ((!$level->who_can_submit) ? 'selected' : ''); ?>><?php esc_html_e("Any users", "w2dc"); ?></option>
						<option value="loggedinusers" <?php echo ((in_array('loggedinusers', $level->who_can_submit)) ? 'selected' : ''); ?>><?php esc_html_e("Any logged in users", "w2dc"); ?></option>
						<?php foreach (get_editable_roles() as $role_name => $role_info): ?>
						<option value="<?php w2dc_esc_e($role_name); ?>" <?php echo ((in_array($role_name, $level->who_can_submit)) ? 'selected' : ''); ?>><?php w2dc_esc_e($role_info['name']); ?></option>
						<?php endforeach; ?>
					</select>
					<p class="description"><?php esc_html_e("Specify what users can submit listings in this level: any users, only logged in users, or select specific users groups.", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Eternal active period', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="eternal_active_period"
						type="checkbox"
						value="1"
						id="eternal_active_period"
						<?php checked($level->eternal_active_period); ?> />
					<p class="description"><?php esc_html_e("Listings will never expire.", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Active period', 'w2dc'); ?></label>
				</th>
				<td>
					<select name="active_interval" id="active_interval" <?php disabled($level->eternal_active_period); ?> >
						<option value="1" <?php if ($level->active_interval == 1) echo 'selected'; ?> >1</option>
						<option value="2" <?php if ($level->active_interval == 2) echo 'selected'; ?> >2</option>
						<option value="3" <?php if ($level->active_interval == 3) echo 'selected'; ?> >3</option>
						<option value="4" <?php if ($level->active_interval == 4) echo 'selected'; ?> >4</option>
						<option value="5" <?php if ($level->active_interval == 5) echo 'selected'; ?> >5</option>
						<option value="6" <?php if ($level->active_interval == 6) echo 'selected'; ?> >6</option>
					</select>
					&nbsp;
					<select name="active_period" id="active_period" <?php disabled($level->eternal_active_period); ?> >
						<option value="day" <?php if ($level->active_period == 'day') echo 'selected'; ?> ><?php esc_html_e("day(s)", "w2dc"); ?></option>
						<option value="week" <?php if ($level->active_period == 'week') echo 'selected'; ?> ><?php esc_html_e("week(s)", "w2dc"); ?></option>
						<option value="month" <?php if ($level->active_period == 'month') echo 'selected'; ?> ><?php esc_html_e("month(s)", "w2dc"); ?></option>
						<option value="year" <?php if ($level->active_period == 'year') echo 'selected'; ?> ><?php esc_html_e("year(s)", "w2dc"); ?></option>
					</select>
					<p class="description">
						<?php esc_html_e("During this period the listing will have active status.", 'w2dc'); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Change level after expiration', 'w2dc'); ?></label>
				</th>
				<td>
					<select name="change_level_id" id="change_level_id" <?php disabled($level->eternal_active_period); ?> >
						<option value="0" <?php if ($level->change_level_id == 0) echo 'selected'; ?> >- <?php esc_html_e("Just suspend", "w2dc"); ?> -</option>
						<?php foreach ($w2dc_instance->levels->levels_array AS $new_level): ?>
						<?php if ($level->id != $new_level->id): ?>
						<option value="<?php w2dc_esc_e($new_level->id); ?>" <?php if ($level->change_level_id == $new_level->id) echo 'selected'; ?> ><?php w2dc_esc_e($new_level->name); ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
					</select>
					<p class="description">
						<?php esc_html_e("After expiration listing will change level automatically.", 'w2dc'); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Number of listings in package', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						id="listings_in_package"
						name="listings_in_package"
						type="text"
						size="1"
						value="<?php w2dc_esc_e($level->listings_in_package); ?>" />
					<p class="description"><?php esc_html_e("Enter more than 1 to allow users get packages of listings. Users will be able to use listings from their package to renew, raise up and upgrade existing listings.", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Ability to raise up listings', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="raiseup_enabled"
						type="checkbox"
						value="1"
						<?php checked($level->raiseup_enabled); ?> />
					<p class="description"><?php esc_html_e("This option may be payment", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Sticky listings', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="sticky"
						type="checkbox"
						value="1"
						<?php checked($level->sticky); ?> />
					<p class="description"><?php esc_html_e("Listings of this level will be on top", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Featured listings', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="featured"
						type="checkbox"
						value="1"
						<?php checked($level->featured); ?> />
					<p class="description"><?php esc_html_e("Listings of this level will be on top and marked as featured", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Do listings have own single pages?', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="listings_own_page"
						type="checkbox"
						value="1"
						<?php checked($level->listings_own_page); ?> />
					<p class="description"><?php esc_html_e("When unchecked - listings info will be shown only on excerpt pages, without links to detailed pages.", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Enable nofollow attribute for links to single listings pages', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="nofollow"
						type="checkbox"
						value="1"
						<?php checked($level->nofollow); ?> />
					<p class="description"><a href="https://developers.google.com/search/docs/crawling-indexing/qualify-outbound-links"><?php esc_html_e("Description from Google Docs", 'w2dc'); ?></a></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Enable map', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="map"
						type="checkbox"
						value="1"
						<?php checked($level->map); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Enable listing logos (thumbnails) on excerpt pages', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="logo_enabled"
						type="checkbox"
						value="1"
						<?php checked($level->logo_enabled); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Images number available', 'w2dc'); ?>
				</th>
				<td>
					<input
						name="images_number"
						type="text"
						size="1"
						value="<?php echo esc_attr($level->images_number); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Videos number available', 'w2dc'); ?>
				</th>
				<td>
					<input
						name="videos_number"
						type="text"
						size="1"
						value="<?php echo esc_attr($level->videos_number); ?>" />
				</td>
			</tr>
			
			<?php do_action('w2dc_level_html', $level); ?>
			
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Locations number available', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="locations_number"
						type="text"
						size="1"
						value="<?php w2dc_esc_e($level->locations_number); ?>" />
				</td>
			</tr>
			<?php if (w2dc_is_maps_used()): ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Custom markers on the map', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="map_markers"
						type="checkbox"
						value="1"
						<?php checked($level->map_markers); ?> />
					<p class="description"><?php esc_html_e("Allow users to select map markers for their locations", 'w2dc'); ?></p>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Categories number available', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="categories_number"
						id="categories_number"
						type="text"
						size="1"
						value="<?php echo esc_attr($level->categories_number); ?>"
						<?php disabled($level->unlimited_categories); ?> />

					<label>
						<input
							name="unlimited_categories"
							id="unlimited_categories"
							type="checkbox"
							value="1"
							<?php checked($level->unlimited_categories); ?> />
						<?php esc_html_e('unlimited categories', 'w2dc'); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Tags number available', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="tags_number"
						id="tags_number"
						type="text"
						size="1"
						value="<?php echo esc_attr($level->tags_number); ?>"
						<?php disabled($level->unlimited_tags); ?> />

					<label>
						<input
							name="unlimited_tags"
							id="unlimited_tags"
							type="checkbox"
							value="1"
							<?php checked($level->unlimited_tags); ?> />
						<?php esc_html_e('unlimited tags', 'w2dc'); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Assigned categories', 'w2dc'); ?></label>
					<?php echo w2dc_get_wpml_dependent_option_description(); ?>
				</th>
				<td>
					<p class="description"><?php esc_html_e('You may define some special categories available for this level', 'w2dc'); ?></p>
					<?php w2dc_termsSelectList('categories', W2DC_CATEGORIES_TAX, $level->categories); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Assigned locations', 'w2dc'); ?></label>
					<?php echo w2dc_get_wpml_dependent_option_description(); ?>
				</th>
				<td>
					<p class="description"><?php esc_html_e('You may define some special locations available for this level', 'w2dc'); ?></p>
					<?php w2dc_termsSelectList('locations', W2DC_LOCATIONS_TAX, $level->locations); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Assigned content fields', 'w2dc'); ?></label>
				</th>
				<td>
					<p class="description"><?php esc_html_e('You may define some special content fields available for this level', 'w2dc'); ?></p>
					<select multiple="multiple" name="content_fields[]" class="selected_terms_list w2dc-form-control w2dc-form-group w2dc-height-300">
					<option value="" <?php echo (!$level->content_fields) ? 'selected' : ''; ?>><?php esc_html_e('- Select All -', 'w2dc'); ?></option>
					<option value="0" <?php echo ($level->content_fields == array(0)) ? 'selected' : ''; ?>><?php esc_html_e('- No fields -', 'w2dc'); ?></option>
					<?php foreach ($content_fields AS $field): ?>
					<?php if (!$field->is_core_field): ?>
					<option value="<?php w2dc_esc_e($field->id); ?>" <?php echo ($level->content_fields && in_array($field->id, $level->content_fields)) ? 'selected' : ''; ?>><?php w2dc_esc_e($field->name); ?></option>
					<?php endif; ?>
					<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php
	if ($level_id)
		submit_button(esc_html__('Save changes', 'w2dc'));
	else
		submit_button(esc_html__('Create level', 'w2dc'));
	?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>