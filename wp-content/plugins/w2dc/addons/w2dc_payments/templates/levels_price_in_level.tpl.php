<?php

// @codingStandardsIgnoreFile

?>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Listings price', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="price"
						type="text"
						size="5"
						value="<?php if (isset($level->price)) w2dc_esc_e($level->price); ?>" /> <?php echo get_option('w2dc_payments_symbol_code'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Listings raise up price', 'w2dc'); ?></label>
				</th>
				<td>
					<input
						name="raiseup_price"
						type="text"
						size="5"
						value="<?php if (isset($level->raiseup_price)) w2dc_esc_e($level->raiseup_price); ?>" /> <?php echo get_option('w2dc_payments_symbol_code'); ?>
				</td>
			</tr>