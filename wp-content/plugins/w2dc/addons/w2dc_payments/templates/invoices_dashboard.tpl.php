<?php

// @codingStandardsIgnoreFile

?>
	<?php if ($frontend_controller->invoices): ?>
		<table class="w2dc-table w2dc-table-striped w2dc-dashboard-invoices">
			<tr>
				<th class="w2dc-td-invoice-title"><?php esc_html_e('Invoice', 'w2dc'); ?></th>
				<th class="w2dc-td-invoice-item"><?php esc_html_e('Item', 'w2dc'); ?></th>
				<th class="w2dc-td-invoice-price"><?php esc_html_e('Price', 'w2dc'); ?></th>
				<th class="w2dc-td-invoice-payment"><?php esc_html_e('Payment', 'w2dc'); ?></th>
				<th class="w2dc-td-invoice-date"><?php esc_html_e('Creation date', 'w2dc'); ?></th>
			</tr>
		<?php while ($frontend_controller->invoices_query->have_posts()): ?>
			<?php $frontend_controller->invoices_query->the_post(); ?>
			<?php $invoice = $frontend_controller->invoices[get_the_ID()]; ?>
			<tr>
				<td class="w2dc-td-invoice-title">
					<?php
					if (w2dc_current_user_can_edit_listing($invoice->post->ID))
						echo '<a href="' . w2dc_get_edit_invoice_link($invoice->post->ID) . '">' . $invoice->post->post_title . '</a>';
					else
						w2dc_esc_e($invoice->post->post_title);
					?>
				</td>
				<td class="w2dc-td-invoice-item"><?php if (is_object($invoice->item_object)) echo $invoice->item_object->getItemLink(); ?></td>
				<td class="w2dc-td-invoice-price"><?php echo $invoice->price(); ?></td>
				<td class="w2dc-td-invoice-payment">
					<?php
					if ($invoice->status == 'unpaid') {
						echo '<span class="w2dc-badge w2dc-invoice-status-unpaid">' . esc_html__('unpaid', 'w2dc') . '</span>';
						if (w2dc_current_user_can_edit_listing($invoice->post->ID))
							echo '<br /><a href="' . w2dc_get_edit_invoice_link($invoice->post->ID) . '">' . esc_html__('pay invoice', 'w2dc') . '</a>';
					} elseif ($invoice->status == 'paid') {
						echo '<span class="w2dc-badge w2dc-invoice-status-paid">' . esc_html__('paid', 'w2dc') . '</span>';
						if ($invoice->gateway)
							echo '<br /><b>' . gatewayName($invoice->gateway) . '</b>';
					} elseif ($invoice->status == 'pending') {
						echo '<span class="w2dc-badge w2dc-invoice-status-pending">' . esc_html__('pending', 'w2dc') . '</span>';
						if ($invoice->gateway)
							echo '<br /><b>' . gatewayName($invoice->gateway) . '</b>';
					}
					?>
				</td>
				<td class="w2dc-td-invoice-date"><?php echo w2dc_formatDateTime(strtotime($invoice->post->post_date)); ?></td>
			</tr>
		<?php endwhile; ?>
		</table>
		<?php w2dc_renderPaginator($frontend_controller->invoices_query, '', false); ?>
	<?php endif; ?>