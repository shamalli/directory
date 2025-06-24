<div class="w2rr-content w2rr-single-review-text-content-wrap">
	<?php if (get_option('w2rr_share_buttons') && get_option('w2rr_share_buttons_place') == 'before_content'): ?>
	<?php w2rr_renderTemplate('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $review->post->ID, 'post_url' => get_permalink($review->post->ID))); ?>
	<?php endif; ?>

	<?php do_action('w2rr_review_pre_content_html', $review); ?>

	<?php if (get_option('w2rr_enable_description')): ?>
	<?php
	add_filter('the_content', 'wpautop');
	
	$query = new WP_Query('name=' . $review->post->post_name . '&post_type=' . W2RR_REVIEW_TYPE);
	while ($query->have_posts()) {
		$query->the_post();
			
		global $w2rr_do_listing_content;
		$w2rr_do_listing_content = true;
		$content = apply_filters('the_content', get_the_content());
		$w2rr_do_listing_content = false;
			
		echo $content;
	}
	
	remove_filter('the_content', 'wpautop');
	
	wp_reset_postdata();
	?>
	<?php endif; ?>

	<?php if (get_option('w2rr_enable_pros_cons')): ?>
	<?php if ($review->pros): ?>
	<h4 class="w2rr-pros-title"><?php esc_html_e('Pros', 'w2rr')?></h4>
	<p class="w2rr-pros-description"><?php echo esc_html($review->pros); ?></p>
	<?php endif; ?>
	<?php if ($review->cons): ?>
	<h4 class="w2rr-cons-title"><?php esc_html_e('Cons', 'w2rr')?></h4>
	<p class="w2rr-cons-description"><?php echo esc_html($review->cons); ?></p>
	<?php endif; ?>
	<?php endif; ?>

	<?php do_action('w2rr_review_post_content_html', $review); ?>

	<?php if (get_option('w2rr_share_buttons') && get_option('w2rr_share_buttons_place') == 'after_content'): ?>
	<?php w2rr_renderTemplate('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $review->post->ID, 'post_url' => get_permalink($review->post->ID))); ?>
	<?php endif; ?>
</div>