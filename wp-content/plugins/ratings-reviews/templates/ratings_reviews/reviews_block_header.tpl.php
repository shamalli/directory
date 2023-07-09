<?php if ($target_post && $target_post->getAvgRating() > 0): ?>
<div class="w2rr-content">
	<div class="w2rr-row w2rr-reviews-block-header">
		<div class="w2rr-col-md-4">
			<?php
				$total_counts = $target_post->avg_rating->calculateTotals();
			?>
			<div class="w2rr-ratings-overall-wrapper">
				<?php foreach ($total_counts AS $rating=>$counts): ?>
				<div class="w2rr-ratings-overall">
					<span class="w2rr-ratings-overall-stars"><?php echo esc_html($rating); ?> <?php echo _n('Star ', 'Stars', $rating, 'W2RR'); ?></span>
					<div class="w2rr-rating">
						<div class="w2rr-progress">
							<div class="w2rr-progress-bar" role="progressbar" style="width: <?php echo $target_post->avg_rating->get_percents_counts($counts); ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				 	&nbsp;-&nbsp;<span class="w2rr-ratings-counts"><?php echo esc_html($counts); ?> (<?php echo $target_post->avg_rating->get_percents_counts($counts); ?>%)</span>
				 </div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="w2rr-col-md-2">
			<div class="w2rr-progress-circle <?php if ($target_post->getAvgRating() > 2.5) echo 'w2rr-over50'; ?> p<?php echo round(($target_post->getAvgRating()-1)*25); ?>">
				<span><?php echo $target_post->getAvgRating(); ?></span>
				<div class="w2rr-left-half-clipper">
					<div class="w2rr-first50-bar"></div>
					<div class="w2rr-value-bar"></div>
				</div>
			</div>
		</div>
		<?php if ($ratings_criterias = w2rr_getMultiRatings()): ?>
		<div class="w2rr-col-md-6">
			<?php w2rr_renderTemplate('ratings_reviews/single_parts/ratings_criterias_overall.tpl.php', array('ratings_criterias' => $ratings_criterias, 'values' => $target_post->avg_rating_criterias->avg_values)); ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>