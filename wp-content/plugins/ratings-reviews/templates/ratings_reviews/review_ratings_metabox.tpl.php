<div class="w2rr-content w2rr-review-ratings-metabox">
	<div class="w2rr-row">
		<div class="w2rr-col-md-9">
			<?php foreach ($ratings_criterias AS $key=>$criteria): ?>
			<div class="w2rr-review-rating-criteria">
				<?php $id = rand(); ?>
				<div class="w2rr-range-slider-criteria-label">
					<?php echo esc_html($criteria); ?>
				</div>
				<div class="w2rr-range-slider-wrapper">
					<span class="w2rr-range-slider-value w2rr-range-slider-<?php echo esc_attr($id); ?>">0</span>
					<div class="w2rr-range-slider">
						<input type="range" min="1" max="9" step="1" value="<?php echo w2rr_getValue($review_ratings, $key, 9)?>" name="w2rr_review_rating_<?php echo esc_attr($key); ?>" class="w2rr-range-slider-input" id="w2rr-range-slider-<?php echo esc_attr($id); ?>" />
						<ul class="w2rr-range-slider-labels w2rr-range-slider-<?php echo esc_attr($id); ?>">
							<li>1</li>
							<li>1.5</li>
							<li>2</li>
							<li>2.5</li>
							<li>3</li>
							<li>3.5</li>
							<li>4</li>
							<li>4.5</li>
							<li>5</li>
						</ul>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="w2rr-col-md-3">
			<h4 class="w2rr-review-rating-criteria-avg-label"><?php esc_html_e("Average rating:", "W2RR"); ?></h4>
			<div class="w2rr-progress-circle p0">
				<span>0.0</span>
				<div class="w2rr-left-half-clipper">
					<div class="w2rr-first50-bar"></div>
					<div class="w2rr-value-bar"></div>
				</div>
			</div>
		</div>
	</div>
</div>