<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php printf(esc_html__('Configure %s field', 'w2dc'), $w2dc_instance->content_fields->fields_types_names[$content_field->type]); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Max length',  'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="max_length"
						type="text"
						size="2"
						value="<?php echo esc_attr($content_field->max_length); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('PHP RegEx template',  'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="regex"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->regex); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Phone mode',  'w2dc'); ?></label>
					<p class="description"><?php esc_html_e("for mobile devices adds special tag to call directly from phone or open needed app", 'w2dc'); ?></p>
				</th>
				<td>
					<input
						id="phone_mode_phone"
						name="phone_mode"
						type="radio"
						value="phone"
						<?php checked('phone', $content_field->phone_mode); ?> /> <label for="phone_mode_phone"><?php esc_html_e('Phone call', 'w2dc'); ?></label>
					</br>
					<input
						id="phone_mode_viber"
						name="phone_mode"
						type="radio"
						value="viber"
						<?php checked('viber', $content_field->phone_mode); ?> /> <label for="phone_mode_viber"><?php esc_html_e('Viber chat', 'w2dc'); ?></label>
					</br>
					<input
						id="phone_mode_whatsapp"
						name="phone_mode"
						type="radio"
						value="whatsapp"
						<?php checked('whatsapp', $content_field->phone_mode); ?> /> <label for="phone_mode_whatsapp"><?php esc_html_e('WhatsApp chat', 'w2dc'); ?></label>
					</br>
					<input
						id="phone_mode_telegram"
						name="phone_mode"
						type="radio"
						value="telegram"
						<?php checked('telegram', $content_field->phone_mode); ?> /> <label for="phone_mode_telegram"><?php esc_html_e('Telegram chat', 'w2dc'); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(esc_html__('Save changes', 'w2dc')); ?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>