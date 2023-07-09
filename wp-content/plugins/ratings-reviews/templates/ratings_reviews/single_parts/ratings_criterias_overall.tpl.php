<div class="w2rr-content">
	<div class="w2rr-review-rating-criterias w2rr-row">
		<?php foreach ($ratings_criterias AS $key=>$criteria): ?>
		<?php if (!empty($values[$key])): ?>
		<div class="w2rr-col-md-6">
			<div class="w2rr-review-rating-criteria">
				<span class="w2rr-review-rating-criteria-label">
					<?php echo esc_html($criteria); ?>
				</span>
				<span class="w2rr-review-rating-criteria-value">
					<?php echo number_format(($values[$key]+1)/2, 1); ?>
				</span>
			</div>
			<div class="w2rr-progress">
				<div class="w2rr-progress-bar" role="progressbar" style="width: <?php echo ($values[$key]-1)*12.5; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>