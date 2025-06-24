<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php
	if ($locations_level_id)
		esc_html_e('Edit locations level', 'w2dc');
	else
		esc_html_e('Create new locations level', 'w2dc');
	?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_locations_levels_nonce');?>
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
						value="<?php w2dc_esc_e($locations_level->name); ?>" />
					<?php w2dc_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('In address line', 'w2dc'); ?></label>
				</th>
				<td>
					<input type="checkbox" value="1" name="in_address_line" <?php if ($locations_level->in_address_line) echo 'checked'; ?> />
					<p class="description"><?php esc_html_e("Render locations of this level in address line", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Allow add term', 'w2dc'); ?></label>
				</th>
				<td>
					<input type="checkbox" value="1" name="allow_add_term" <?php if ($locations_level->allow_add_term) echo 'checked'; ?> />
					<p class="description"><?php esc_html_e("Users able to add new location from the frontend", 'w2dc'); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php
	if ($locations_level_id)
		submit_button(esc_html__('Save changes', 'w2dc'));
	else
		submit_button(esc_html__('Create locations level', 'w2dc'));
	?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>