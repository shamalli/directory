<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php
	if ($group_id)
		esc_html_e('Edit content fields group', 'w2dc');
	else
		esc_html_e('Create new content fields group', 'w2dc');
	?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Fields Group name', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="name"
						id="content_fields_group_name"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_fields_group->name); ?>" />
						<?php w2dc_wpmlTranslationCompleteNotice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('On tab', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="on_tab"
						type="checkbox"
						value="1"
						<?php checked($content_fields_group->on_tab); ?> />
					<p class="description"><?php esc_html_e("Place this group on separate tab on single listings pages", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Hide from anonymous users', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="hide_anonymous"
						type="checkbox"
						value="1"
						<?php checked($content_fields_group->hide_anonymous); ?> />
					<p class="description"><?php esc_html_e("This group of fields will be shown only for registered users", 'w2dc'); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php
	if ($group_id)
		submit_button(esc_html__('Save changes', 'w2dc'));
	else
		submit_button(esc_html__('Create content fields group', 'w2dc'));
	?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>