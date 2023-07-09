<div class="w2rr-content">
	<div class="w2rr-write-review">
		<?php if (w2rr_show_add_review_button($post_id)): ?>
		<a class="w2rr-add-review-link w2rr-btn w2rr-btn-primary" href="<?php echo w2rr_get_add_review_link($post_id); ?>" rel="nofollow"><?php if (isset($text)) echo $text; else esc_html_e('Add Review', 'W2RR'); ?></a>
		<?php else: ?>
		<?php echo w2rr_show_add_review_button_message($post_id); ?>
		<?php endif; ?>
	</div>
</div>