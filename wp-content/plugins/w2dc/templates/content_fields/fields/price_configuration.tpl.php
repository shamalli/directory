<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php esc_html_e('Configure price field', 'w2dc'); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(W2DC_PATH, 'w2dc_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Currency symbol', 'w2dc'); ?><span class="w2dc-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="currency_symbol"
						type="text"
						size="1"
						value="<?php echo esc_attr($content_field->currency_symbol); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Currency symbol position', 'w2dc'); ?></label>
				</th>
				<td>
					<select name="symbol_position">
						<option value="1" <?php if($content_field->symbol_position == '1') echo 'selected'; ?>>$1.00</option>
						<option value="2" <?php if($content_field->symbol_position == '2') echo 'selected'; ?>>$ 1.00</option>
						<option value="3" <?php if($content_field->symbol_position == '3') echo 'selected'; ?>>1.00$</option>
						<option value="4" <?php if($content_field->symbol_position == '4') echo 'selected'; ?>>1.00 $</option>
					</select>
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
					<label><?php esc_html_e('Hide decimals', 'w2dc'); ?></label>
				</th>
				<td>
					<select name="hide_decimals">
						<option value="0" <?php if($content_field->hide_decimals == '0') echo 'selected'; ?>><?php esc_html_e('no', 'w2dc')?></option>
						<option value="1" <?php if($content_field->hide_decimals == '1') echo 'selected'; ?>><?php esc_html_e('yes', 'w2dc')?></option>
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
		</tbody>
	</table>
	
	<?php submit_button(esc_html__('Save changes', 'w2dc')); ?>
</form>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>