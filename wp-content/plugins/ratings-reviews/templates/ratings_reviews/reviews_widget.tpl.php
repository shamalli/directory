		<div class="w2rr-content" id="w2rr-controller-<?php echo $frontend_controller->hash; ?>" data-controller-hash="<?php echo $frontend_controller->hash; ?>">
			<?php while ($frontend_controller->query->have_posts()): ?>
			<?php $frontend_controller->query->the_post(); ?>
			<article id="post-<?php the_ID(); ?>" class="w2rr-reviews-widget-item">
				<?php $review = $frontend_controller->reviews[get_the_ID()]; ?>
				<?php
				$review->renderStars();
				?>
				<div class="w2rr-meta-data">
					<div class="w2rr-review-date" datetime="<?php echo date("Y-m-d", mysql2date('U', $review->post->post_date)); ?>T<?php echo date("H:i", mysql2date('U', $review->post->post_date)); ?>"><?php echo get_the_date(); ?> <?php echo get_the_time(); ?></div>
				</div>
				<h4 class="w2rr-review-title">
					<a href="<?php echo $review->url(); ?>" onClick="w2rr_show_review(<?php echo esc_attr($review->post->ID); ?>, '<?php echo esc_html($review->title()); ?>')"><?php echo esc_html($review->title()); ?></a>
				</h4>
				<div class="w2rr-review-summary">
					<?php echo w2rr_crop_content($review->post->ID, 15); ?>
				</div>
				<?php if ($review->images): ?>
				<div class="w2rr-review-images">
					<ul class="w2rr-clearfix">
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
			</article>
			<?php endwhile; ?>
		</div>