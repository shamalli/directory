<?php 
/* 

Used in:
ratings_manager.php
ratings.php
reviews_manager.php
edit_review.tpl.php
review_add.tpl.php

*/
?>
<div class="w2rr-rating-wrapper">
	<div class="w2rr-rating" style="font-size: <?php w2rr_esc_e($stars_size); ?>px" <?php if ($meta_tags && $avg_rating->ratings_count): ?>itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"<?php endif; ?>>
		<?php if ($meta_tags && $avg_rating->ratings_count): ?>
		<?php if ($review_count = get_comments_number()): ?><meta itemprop="reviewCount" content="<?php echo esc_attr($review_count); ?>" /><?php endif; ?>
		<meta itemprop="ratingValue" content="<?php echo esc_attr($avg_rating->avg_value); ?>" />
		<meta itemprop="ratingCount" content="<?php echo esc_attr($avg_rating->ratings_count); ?>" />
		<?php endif; ?>
		<?php if ($show_avg): ?>
		<span class="w2rr-rating-avgvalue">
			<span class="w2rr-rating-avgvalue-digit">
				<span class="w2rr-rating-avgvalue-digit-text">
					<?php w2rr_esc_e($avg_rating->avg_value); ?>
				</span>
			</span>
		</span>
		<?php endif; ?>
		<div class="w2rr-rating-stars <?php if ($active): ?>w2rr-rating-active<?php endif; ?> <?php if (!empty($noajax)): ?>w2rr-rating-active-noajax<?php endif; ?>" <?php if (!empty($post_id)): ?>data-post="<?php echo esc_attr($post_id); ?>"<?php endif; ?> style="width: <?php echo $stars_size*5; ?>px" data-nonce="<?php echo wp_create_nonce('save_rating')?>">
			<label class="w2rr-rating-icon w2rr-fa <?php echo $avg_rating->render_star(5); ?>" style="width: <?php w2rr_esc_e($stars_size); ?>px" <?php if (!empty($post_id)): ?>for="star-rating-5-<?php echo esc_attr($post_id); ?>"<?php endif; ?> data-rating="5"></label>
			<label class="w2rr-rating-icon w2rr-fa <?php echo $avg_rating->render_star(4); ?>" style="width: <?php w2rr_esc_e($stars_size); ?>px" <?php if (!empty($post_id)): ?>for="star-rating-4-<?php echo esc_attr($post_id); ?>"<?php endif; ?> data-rating="4"></label>
			<label class="w2rr-rating-icon w2rr-fa <?php echo $avg_rating->render_star(3); ?>" style="width: <?php w2rr_esc_e($stars_size); ?>px" <?php if (!empty($post_id)): ?>for="star-rating-3-<?php echo esc_attr($post_id); ?>"<?php endif; ?> data-rating="3"></label>
			<label class="w2rr-rating-icon w2rr-fa <?php echo $avg_rating->render_star(2); ?>" style="width: <?php w2rr_esc_e($stars_size); ?>px" <?php if (!empty($post_id)): ?>for="star-rating-2-<?php echo esc_attr($post_id); ?>"<?php endif; ?> data-rating="2"></label>
			<label class="w2rr-rating-icon w2rr-fa <?php echo $avg_rating->render_star(1); ?>" style="width: <?php w2rr_esc_e($stars_size); ?>px" <?php if (!empty($post_id)): ?>for="star-rating-1-<?php echo esc_attr($post_id); ?>"<?php endif; ?> data-rating="1"></label>
			<?php if (!empty($noajax)): ?>
			<input type="hidden" name="w2rr-rating-noajax-<?php echo $post_id; ?>" class="w2rr-rating-noajax-value" value="<?php echo esc_attr($avg_rating->avg_value); ?>">
			<?php endif; ?>
		</div>
	</div>
	<?php
	if ($show_counter) {
	?>
	<a class="w2rr-counter-reviews-link" href="<?php echo apply_filters("w2rr_counter_reviews_link", get_permalink($post_id), $post_id); ?>">(<?php echo w2rr_getActiveReviewsCounterByPostId($post_id); ?> <?php echo _n('Review', 'Reviews', w2rr_getActiveReviewsCounterByPostId($post_id), 'w2rr'); ?>)</a>
	<?php 
	} 
	?>
</div>