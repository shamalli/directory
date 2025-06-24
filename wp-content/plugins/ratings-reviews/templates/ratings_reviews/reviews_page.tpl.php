		<div class="w2rr-content w2rr-reviews-page">
			<?php w2rr_renderMessages(); ?>
			
			<?php w2rr_renderTemplate('ratings_reviews/add_review_button.tpl.php', array('post_id' => $target_post->post->ID)); ?>

			<?php if ($frontend_controller->getPageTitle()): ?>
			<header class="w2rr-page-header">
				<?php $frontend_controller->printBreadCrumbs(); ?>
			</header>
			<?php endif; ?>
			
			<h3><?php echo $reviews_controller->query->found_posts; ?> <?php echo _n('Review', 'Reviews', $reviews_controller->query->found_posts, 'w2rr'); ?></h3>
			
			<?php w2rr_renderTemplate('ratings_reviews/reviews_block_header.tpl.php', array('target_post' => $target_post)); ?>
			<?php echo $reviews_controller->display(); ?>
		</div>