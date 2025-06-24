<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php echo apply_filters('w2dc_raiseup_option', sprintf(esc_html__('Raise up listing "%s"', 'w2dc'), $listing->title()), $listing); ?>
</h2>

<p><?php esc_html_e('Listing will be raised up to the top of all lists, those ordered by date.', 'w2dc'); ?></p>
<p><?php esc_html_e('Note, that listing will not stick on top, so new listings and other listings, those were raised up later, will place higher.', 'w2dc'); ?></p>

<?php do_action('w2dc_raise_up_html', $listing); ?>

<?php if ($action == 'show'): ?>
<a href="<?php echo admin_url('options.php?page=w2dc_raise_up&listing_id=' . $listing->post->ID . '&raiseup_action=raiseup&referer=' . urlencode($referer)); ?>" class="button button-primary"><?php esc_html_e('Raise up', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo esc_attr($referer); ?>" class="button button-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>
<?php elseif ($action == 'raiseup'): ?>
<a href="<?php echo esc_attr($referer); ?>" class="button button-primary"><?php esc_html_e('Go back ', 'w2dc'); ?></a>
<?php endif; ?>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>