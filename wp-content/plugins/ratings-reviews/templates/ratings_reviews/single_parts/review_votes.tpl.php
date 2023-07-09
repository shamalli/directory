<div class="w2rr-content">
	<div class="w2rr-review-votes">
		<span class="w2rr-review-votes-question"><?php esc_html_e('Helpful review?', 'W2RR'); ?></span>
		<a class="w2rr-btn w2rr-btn-primary w2rr-review-votes-button w2rr-review-votes-button-up <?php if ($review->current_user_voted === 0) echo 'w2rr-review-votes-button-inactive'; ?>" title="<?php esc_attr_e('vote up', 'W2RR')?>" data-review="<?php echo $review->post->ID; ?>" data-nonce="<?php echo wp_create_nonce('review_vote')?>">
			<span class="w2rr-glyphicon w2rr-glyphicon-thumbs-up"></span>
			<span class="w2rr-review-votes-counter w2rr-review-votes-counter-up">
				<?php echo $review->votes_up; ?>
			</span>
		</a>
		<a class="w2rr-btn w2rr-btn-primary w2rr-review-votes-button w2rr-review-votes-button-down <?php if ($review->current_user_voted === 1) echo 'w2rr-review-votes-button-inactive'; ?>" title="<?php esc_attr_e('vote down', 'W2RR')?>" data-review="<?php echo $review->post->ID; ?>" data-nonce="<?php echo wp_create_nonce('review_vote')?>">
			<span class="w2rr-glyphicon w2rr-glyphicon-thumbs-down"></span>
			<span class="w2rr-review-votes-counter w2rr-review-votes-counter-down">
				<?php echo $review->votes_down; ?>
			</span>
		</a>
	</div>
</div>