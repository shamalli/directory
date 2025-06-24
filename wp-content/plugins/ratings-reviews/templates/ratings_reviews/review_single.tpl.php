		<div class="w2rr-content w2rr-review-single">
			<?php w2rr_renderMessages(); ?>

			<?php while ($reviews_controller->query->have_posts()): ?>
				<?php $reviews_controller->query->the_post(); ?>
				<?php $review = $reviews_controller->reviews[get_the_ID()]; ?>
				
				<?php $review->printMicrodata(); ?>
				
				<?php w2rr_renderTemplate('ratings_reviews/add_review_button.tpl.php', array('post_id' => $review->target_post->post->ID)); ?>
			
				<div id="<?php echo esc_attr($review->post->post_name); ?>">
				
					<?php w2rr_renderTemplate('ratings_reviews/single_parts/header.tpl.php', array('review' => $review, 'frontend_controller' => $frontend_controller)); ?>

					<article id="post-<?php echo esc_attr($review->post->ID); ?>" class="w2rr-review">
						<?php if ($review->images): ?>
						<?php w2rr_renderTemplate('ratings_reviews/single_parts/gallery.tpl.php', array('review' => $review)); ?>
						<?php endif; ?>
						
						<?php w2rr_renderTemplate('ratings_reviews/single_parts/content.tpl.php', array('review' => $review)); ?>

						<?php if ($ratings_criterias = w2rr_getMultiRatings()): ?>
						<?php w2rr_renderTemplate('ratings_reviews/single_parts/ratings_criterias_overall.tpl.php', array('ratings_criterias' => $ratings_criterias, 'values' => $review->ratings)); ?>
						<?php endif; ?>
						
						<div class="w2rr-single-review-comments-votes w2rr-row">
							<?php if (get_option("w2rr_reviews_votes")): ?>
							<div class="w2rr-single-review-votes w2rr-col-md-6 w2rr-pull-right">
								<?php w2rr_renderTemplate('ratings_reviews/single_parts/review_votes.tpl.php', array('review' => $review)); ?>
							</div>
							<?php endif; ?>
						</div>
						
						<?php if (w2rr_comments_open()): ?>
						<div class="w2rr-single-review-comments">
							<div class="w2rr-single-review-comments-label">
								<?php echo $review->post->comment_count; ?> <?php echo _n('Comment', 'Comments', $review->post->comment_count, 'w2rr'); ?>
							</div>
							<?php w2rr_renderTemplate('ratings_reviews/single_parts/comments.tpl.php', array('post' => $review->post)); ?>
						</div>
						<?php endif; ?>
					</article>
				</div>
			<?php endwhile; ?>
		</div>