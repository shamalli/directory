<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php printf(esc_html__('Approve or decline claim of listing "%s"', 'w2dc'), $listing->title()); ?>
</h2>

<?php if ($action == 'show'): ?>
<p><?php printf(esc_html__('User "%s" had claimed this listing.', 'w2dc'), $listing->claim->claimer->display_name); ?></p>
<?php if ($listing->claim->claimer_message): ?>
<p><?php esc_html_e('Message from claimer:', 'w2dc'); ?><br /><i><?php w2dc_esc_e($listing->claim->claimer_message); ?></i></p>
<?php endif; ?>
<p><?php esc_html_e('Claimer will receive email notification.', 'w2dc'); ?></p>

<a href="<?php echo admin_url('options.php?page=w2dc_process_claim&listing_id=' . $listing->post->ID . '&claim_action=approve&referer=' . urlencode($referer)); ?>" class="button button-primary"><?php esc_html_e('Approve', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo admin_url('options.php?page=w2dc_process_claim&listing_id=' . $listing->post->ID . '&claim_action=decline&referer=' . urlencode($referer)); ?>" class="button button-primary"><?php esc_html_e('Decline', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo esc_attr($referer); ?>" class="button button-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>
<?php elseif ($action == 'processed'): ?>
<a href="<?php echo esc_attr($referer); ?>" class="button button-primary"><?php esc_html_e('Go back ', 'w2dc'); ?></a>
<?php endif; ?>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>