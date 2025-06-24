<div class="w2rr-row">
	<div class="w2rr-col-md-3 w2rr-review-info-container">
		<?php
		$review->renderStars();
		?>
		<?php if (!get_option('w2rr_hide_author_link')): ?>
		<div class="w2rr-meta-data">
			<?php if ($review->getUserPicURL()): ?>
			<div class="w2rr-author-picture">
				<?php echo $review->renderUserPic(); ?>
			</div>
			<?php endif; ?>
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
	<div class="w2rr-col-md-9 w2rr-review-body">
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
		<h4 class="w2rr-pros-title"><?php esc_html_e('Pros', 'w2rr')?></h4>
		<p class="w2rr-pros-description"><?php echo esc_html($review->pros); ?></p>
		<?php endif; ?>
		<?php if ($review->cons): ?>
		<h4 class="w2rr-cons-title"><?php esc_html_e('Cons', 'w2rr')?></h4>
		<p class="w2rr-cons-description"><?php echo esc_html($review->cons); ?></p>
		<?php endif; ?>
		<?php endif; ?>
		<?php if ($review->images && empty($frontend_controller->args['hide_images'])): ?>
		<div class="w2rr-review-images">
			<ul>
				<?php foreach ($review->images AS $attachment_id=>$image): ?>
				<?php $image_src = wp_get_attachment_image_src($attachment_id, array(60, 60)); ?>
				<?php $image_title = $image['post_title']; ?>
				<li class="w2rr-review-image">
					<a href="<?php echo $review->url(); ?>" onClick="w2rr_show_review(<?php echo esc_attr($review->post->ID); ?>, '<?php echo esc_html($review->title()); ?>')"><img src="<?php echo $image_src[0]; ?>" alt="<?php echo esc_attr($image_title); ?>" title="<?php echo esc_attr($image_title); ?>"></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
	</div>
	<div class="w2rr-col-md-9 w2rr-col-md-offset-3 w2rr-review-footer">
		<div class="w2rr-review-comments">
			<?php if ($review->post->comment_count): ?>
			<a href="<?php echo $review->url()?>#comments" onClick="w2rr_show_review(<?php echo esc_attr($review->post->ID); ?>, '<?php echo esc_html($review->title()); ?>')"><?php echo $review->post->comment_count; ?> <?php echo _n('Comment', 'Comments', $review->post->comment_count, 'w2rr'); ?></a>
			<?php endif; ?>
		</div>
		<?php if (get_option("w2rr_reviews_votes")): ?>
		<?php w2rr_renderTemplate('ratings_reviews/single_parts/review_votes.tpl.php', array('review' => $review)); ?>
		<?php endif; ?>
	</div>
</div>