<?php

// @codingStandardsIgnoreFile

?>
<?php w2dc_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php echo apply_filters('w2dc_renew_option', esc_html__('Renew listing', 'w2dc'), $listing); ?>
</h2>

<p><?php esc_html_e('Listing will be renewed and raised up to the top of all lists, those ordered by date.', 'w2dc'); ?></p>

<?php do_action('w2dc_renew_html', $listing); ?>

<?php if ($action == 'show'): ?>
<a href="<?php echo admin_url('options.php?page=w2dc_renew&listing_id=' . $listing->post->ID . '&renew_action=renew&referer=' . urlencode($referer)); ?>" class="button button-primary"><?php esc_html_e('Renew listing', 'w2dc'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo esc_attr($referer); ?>" class="button button-primary"><?php esc_html_e('Cancel', 'w2dc'); ?></a>
<?php elseif ($action == 'renew'): ?>
<a href="<?php echo esc_attr($referer); ?>" class="button button-primary"><?php esc_html_e('Go back ', 'w2dc'); ?></a>
<?php endif; ?>

<?php w2dc_renderTemplate('admin_footer.tpl.php'); ?>