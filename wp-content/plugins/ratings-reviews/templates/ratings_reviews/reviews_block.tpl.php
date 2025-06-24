		<div class="w2rr-content" id="w2rr-controller-<?php w2rr_esc_e($frontend_controller->hash); ?>" data-controller-hash="<?php w2rr_esc_e($frontend_controller->hash); ?>">
			<script>
				w2rr_controller_args_array['<?php w2rr_esc_e($frontend_controller->hash); ?>'] = <?php echo json_encode(array_merge(array('controller' => $frontend_controller->request_by, 'base_url' => $frontend_controller->base_url), $frontend_controller->args)); ?>;
			</script>
			<div class="<?php echo esc_attr($frontend_controller->getReviewsBlockClasses()); ?>">
			<?php if ($frontend_controller->query->found_posts): ?>
				<?php if (!$frontend_controller->args['hide_order']): ?>
				<div class="w2rr-row w2rr-reviews-options-links-wrapper">
					<div class="w2rr-reviews-options-links">
						<?php $ordering = w2rr_reviewsOrderLinks($frontend_controller->base_url, $frontend_controller->args, true, $frontend_controller->hash); ?>
						<?php if ($ordering && ($links = $ordering->getLinks('reviews_order_by', 'reviews_order'))): ?>
						<div class="w2rr-reviews-orderby">
							<div class="w2rr-reviews-orderby-dropbtn w2rr-btn w2rr-btn-primary"><?php esc_html_e('Sort reviews by:', 'w2rr'); ?> <?php echo esc_html($ordering->active_link_name); ?></div>
							<div class="w2rr-reviews-orderby-links-group" role="group">
								<?php foreach ($links AS $link): ?>
								<?php if ($link['field_slug'] != $ordering->active_link || $link['order'] != $ordering->active_link_order): ?>
								<a class="w2rr-reviews-orderby-link w2rr-btn" href="<?php w2rr_esc_e($link['url']); ?>" data-controller-hash="<?php w2rr_esc_e($frontend_controller->hash); ?>" data-orderby="<?php echo esc_attr($link['field_slug']); ?>" data-order="<?php echo esc_attr($link['order']); ?>" rel="nofollow">
									<?php echo $link['field_name']; ?>
								</a>
								<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<div class="w2rr-reviews-block-content">
					<?php do_action("w2rr_reviews_block_content_start", $frontend_controller); ?>
					<?php while ($frontend_controller->query->have_posts()): ?>
					<?php $frontend_controller->query->the_post(); ?>
					<article id="post-<?php the_ID(); ?>" class="w2rr-row w2rr-review w2rr-review-wrapper <?php echo implode(' ', $frontend_controller->getReviewClasses()); ?>">
						<?php $frontend_controller->reviews[get_the_ID()]->display($frontend_controller); ?>
						<?php do_action("w2rr_reviews_block_review", $frontend_controller); ?>
					</article>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); // required to close the loop ?>
					<?php do_action("w2rr_reviews_block_content_end", $frontend_controller); ?>
				</div>
				
				<?php $frontend_controller->printPaginatorButtons(); ?>
				
			<?php else: ?>
				<div class="w2rr-row w2rr-no-found-reviews"><?php echo apply_filters("w2rr_no_reviews_text", esc_html__("There are no reviews yet.", "w2rr")); ?></div>
			<?php endif; ?>
			</div>
		</div>