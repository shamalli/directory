<?php
	if (!defined('ABSPATH')) die('You cannot access this template file directly');
?>

<?php if (!($target_post = w2rr_getTargetPost())) die('Target post was not loaded'); ?>

<div class="w2rr-content">
<?php w2rr_renderTemplate('ratings_reviews/add_review_button.tpl.php', array('post_id' => $target_post->post->ID)); ?>

<?php 
	$reviews_controller = new w2rr_reviews_controller;
	$reviews_controller->init(array(
			'comments_template' => true,
			'posts' => array($target_post->post->ID),
			'hide_order' => (int)(!get_option('w2rr_show_orderby_links')),
			'perpage' => get_option('w2rr_reviews_number_per_page'),
			'reviews_view_type' => get_option('w2rr_views_switcher_default'),
			'reviews_view_grid_columns' => get_option('w2rr_reviews_view_grid_columns'),
			'reviews_view_grid_masonry' => get_option('w2rr_reviews_view_grid_masonry'),
	));

	w2rr_setFrontendController(W2RR_REVIEWS_SHORTCODE, $reviews_controller);
?>
	<h3><?php echo $reviews_controller->query->found_posts; ?> <?php echo _n('Review', 'Reviews', $reviews_controller->query->found_posts, 'w2rr'); ?></h3>
	
<?php
	w2rr_renderTemplate('ratings_reviews/reviews_block_header.tpl.php', array('target_post' => $target_post));

	echo $reviews_controller->display();
?>
</div>