<?php

// @codingStandardsIgnoreFile

?>
<div id="misc-publishing-actions">
	<?php if (get_option('w2dc_enable_taxes')): ?>
	<div class="misc-pub-section">
		<span>
			<?php echo nl2br(get_option('w2dc_taxes_info')); ?>
		</span>
	</div>
	<?php endif; ?>
	<div class="misc-pub-section">
		<span>
			<b><?php w2dc_esc_e($invoice->post->post_title); ?></b>
		</span>
	</div>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Listing ID', 'w2dc'); ?>:</label>
		<span>
			<b><?php if (is_object($invoice->item_object)) echo $invoice->item_object->getItemId(); ?></b>
		</span>
	</div>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Invoice ID', 'w2dc'); ?>:</label>
		<span>
			<b><?php w2dc_esc_e($invoice->post->ID); ?></b>
		</span>
	</div>
	<?php if ($invoice->post->post_author != get_current_user_id()): ?>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Author', 'w2dc'); ?>:</label>
		<span>
			<a href="<?php echo get_edit_user_link($invoice->post->post_author); ?>"><?php echo get_userdata($invoice->post->post_author)->user_login; ?></a>
		</span>
	</div>
	<?php endif; ?>
	<?php if ($billing_info = $invoice->billingInfo()): ?>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Bill To', 'w2dc'); ?>:</label>
		<span>
			<?php w2dc_esc_e($billing_info); ?>
		</span>
	</div>
	<?php endif; ?>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Item', 'w2dc'); ?>:</label>
		<span>
			<?php if (is_object($invoice->item_object)) echo $invoice->item_object->getItemLink(); ?>
		</span>
	</div>
	<?php if ($invoice->item_object->getItemOptions()): ?>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Item options', 'w2dc'); ?>:</label>
		<span>
			<b><?php echo $invoice->item_object->getItemOptionsString(); ?></b>
		</span>
	</div>
	<?php endif; ?>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Price', 'w2dc'); ?>:</label>
		<span>
			<b><?php echo $invoice->price(); ?></b> <?php echo $invoice->taxesString(); ?>
		</span>
	</div>
	<?php if (get_option('w2dc_enable_taxes') && get_option('w2dc_tax_name')): ?>
	<div class="misc-pub-section">
		<label><?php echo get_option('w2dc_tax_name'); ?>:</label>
		<span>
			<b><?php echo $invoice->taxesAmount(); ?></b>
		</span>
	</div>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Total', 'w2dc'); ?>:</label>
		<span>
			<b><?php echo $invoice->taxesPrice(); ?></b>
		</span>
	</div>
	<?php endif; ?>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Status', 'w2dc'); ?>:</label>
		<?php if ($invoice->status == 'unpaid')
			echo '<span class="w2dc-badge w2dc-invoice-status-unpaid">' . esc_html__('unpaid', 'w2dc') . '</span>';
		elseif ($invoice->status == 'paid')
			echo '<span class="w2dc-badge w2dc-invoice-status-paid">' . esc_html__('paid', 'w2dc') . '</span>';
		elseif ($invoice->status == 'pending')
			echo '<span class="w2dc-badge w2dc-invoice-status-pending">' . esc_html__('pending', 'w2dc') . '</span>';
		?>
		<?php do_action('w2dc_invoice_status_option', $invoice); ?>
	</div>
	<?php if ($invoice->gateway): ?>
	<div class="misc-pub-section">
		<label><?php esc_html_e('Gateway', 'w2dc'); ?>:</label>
		<span>
			<b><?php echo gatewayName($invoice->gateway); ?></b>
		</span>
	</div>
	<?php endif; ?>
</div>