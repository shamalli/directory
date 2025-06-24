<?php

// @codingStandardsIgnoreFile

?>
<table class="app-message-log widefat">
	<tr>
		<th><?php esc_html_e('Logged Date', 'w2dc'); ?></th>
		<th><?php esc_html_e('Message', 'w2dc'); ?></th>
	</tr>
	<?php $logs = $invoice->log; ?>
	<?php krsort($logs, SORT_NUMERIC); ?>
	<?php foreach ($logs AS $date=>$message): ?>
	<tr class="major">
		<td>
			<span class="timestamp">
				<?php echo w2dc_formatDateTime($date); ?>
			</span>
		</td>
		<td>
			<span class="message"><?php w2dc_esc_e($message); ?></span>
		</td>
	</tr>
	<?php endforeach; ?>
</table>