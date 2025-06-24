<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php esc_html_e('Configure number field', 'w2dc'); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Is integer or decimal', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="is_integer"
						type="radio"
						value="1"
						<?php if($content_field->is_integer) echo 'checked'; ?> />
					<?php esc_html_e('integer', 'w2dc')?>
					&nbsp;&nbsp;
					<input
						name="is_integer"
						type="radio"
						value="0"
						<?php if(!$content_field->is_integer) echo 'checked'; ?> />
					<?php esc_html_e('decimal', 'w2dc')?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Decimal separator', 'w2dc'); ?></label>
				</th>
				<td>
					<select name="decimal_separator">
						<option value="." <?php if($content_field->decimal_separator == '.') echo 'selected'; ?>><?php esc_html_e('dot', 'w2dc')?></option>
						<option value="," <?php if($content_field->decimal_separator == ',') echo 'selected'; ?>><?php esc_html_e('comma', 'w2dc')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Thousands separator', 'w2dc'); ?></label>
				</th>
				<td>
					<select name="thousands_separator">
						<option value="" <?php if($content_field->thousands_separator == '') echo 'selected'; ?>><?php esc_html_e('no separator', 'w2dc')?></option>
						<option value="." <?php if($content_field->thousands_separator == '.') echo 'selected'; ?>><?php esc_html_e('dot', 'w2dc')?></option>
						<option value="," <?php if($content_field->thousands_separator == ',') echo 'selected'; ?>><?php esc_html_e('comma', 'w2dc')?></option>
						<option value=" " <?php if($content_field->thousands_separator == ' ') echo 'selected'; ?>><?php esc_html_e('space', 'w2dc')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Min', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="min"
						type="text"
						size="2"
						value="<?php echo esc_attr($content_field->min); ?>" />
					<p class="description"><?php esc_html_e("leave empty if you do not need to limit this field", 'w2dc'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Max', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="max"
						type="text"
						size="2"
						value="<?php echo esc_attr($content_field->max); ?>" />
					<p class="description"><?php esc_html_e("leave empty if you do not need to limit this field", 'w2dc'); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(esc_html__('Save changes', 'w2dc')); ?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>