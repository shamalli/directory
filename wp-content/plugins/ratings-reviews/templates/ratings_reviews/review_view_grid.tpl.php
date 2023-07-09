	<?php if ($review->logo_image && empty($frontend_controller->args['hide_images'])): ?>
	<?php $image_src = wp_get_attachment_image_src($review->logo_image, array(500, 500)); ?>
	<div class="w2rr-review-logo-wrap">
		<div class="w2rr-review-logo">
			<a href="<?php echo $review->url(); ?>" onClick="w2rr_show_review(<?php echo esc_attr($review->post->ID); ?>, '<?php echo esc_html($review->title()); ?>')"><img src="<?php echo $image_src[0]; ?>"></a>
		</div>
		<div class="w2rr-review-logo-bottom-panel">
			<?php $review->renderStars(); ?> <?php echo $review->getAvgRating(); ?>
		</div>
	</div>
	<?php else: ?>
	<?php $review->renderStars(); ?>
	<?php endif; ?>
	<div class="w2rr-review-info-container">
		<?php if (!get_option('w2rr_hide_author_link')): ?>
		<div class="w2rr-meta-data">
			<div class="w2rr-author-link">
				<?php echo get_the_author_link(); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if (!get_option('w2rr_hide_creation_date')): ?>
		<div class="w2rr-meta-data">
			<div class="w2rr-review-date" datetime="<?php echo date("Y-m-d", mysql2date('U', $review->post->post_date)); ?>T<?php echo date("H:i", mysql2date('U', $review->post->post_date)); ?>"><?php echo get_the_date(); ?> <?php echo get_the_time(); ?></div>
		</div>
		<?php endif; ?>
	</div>
	<div class="w2rr-review-body">
		<h4 class="w2rr-review-title">
			<a href="<?php echo $review->url(); ?>" onClick="w2rr_show_review(<?php echo esc_attr($review->post->ID); ?>, '<?php echo esc_html($review->title()); ?>')"><?php echo esc_html($review->title()); ?></a>
		</h4>
		<?php if (get_option('w2rr_enable_summary')): ?>
		<div class="w2rr-review-summary">
			<?php echo w2rr_crop_content($review->post->ID, get_option('w2rr_excerpt_length')); ?>
		</div>
		<?php endif; ?>
		
		<?php if (get_option('w2rr_enable_pros_cons')): ?>
		<?php if ($review->pros): ?>
		<h4 class="w2rr-pros-title"><?php esc_html_e('Pros', 'W2RR')?></h4>
		<p class="w2rr-pros-description"><?php echo esc_html($review->pros); ?></p>
		<?php endif; ?>
		<?php if ($review->cons): ?>
		<h4 class="w2rr-cons-title"><?php esc_html_e('Cons', 'W2RR')?></h4>
		<p class="w2rr-cons-description"><?php echo esc_html($review->cons); ?></p>
		<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="w2rr-review-footer">
		<div class="w2rr-review-comments">
			<?php if ($review->post->comment_count): ?>
			<a href="<?php echo $review->url()?>#comments" onClick="w2rr_show_review(<?php echo esc_attr($review->post->ID); ?>, '<?php echo esc_html($review->title()); ?>')"><?php echo $review->post->comment_count; ?> <?php echo _n('Comment', 'Comments', $review->post->comment_count, 'W2RR'); ?></a>
			<?php endif; ?>
		</div>
		<?php if (get_option("w2rr_reviews_votes")): ?>
		<?php w2rr_renderTemplate('ratings_reviews/single_parts/review_votes.tpl.php', array('review' => $review)); ?>
		<?php endif; ?>
	</div>