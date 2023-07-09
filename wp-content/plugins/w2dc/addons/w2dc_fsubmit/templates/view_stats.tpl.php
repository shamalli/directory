<div class="w2dc-content">
	<h3><?php echo sprintf(__('Clicks statistics of the page "%s"', 'W2DC'), $object->title()); ?></h3>
	
	<h4><?php echo sprintf(__('Click stats: %d', 'W2DC'), (get_post_meta($object->post->ID, '_total_clicks', true) ? get_post_meta($object->post->ID, '_total_clicks', true) : 0)); ?></h4>
	
	<?php 
	$months_names = array(
		1 => __('January', 'W2DC'),	
		2 => __('February', 'W2DC'),	
		3 => __('March', 'W2DC'),	
		4 => __('April', 'W2DC'),	
		5 => __('May', 'W2DC'),	
		6 => __('June', 'W2DC'),	
		7 => __('July', 'W2DC'),	
		8 => __('August', 'W2DC'),	
		9 => __('September', 'W2DC'),	
		10 => __('October', 'W2DC'),	
		11 => __('November', 'W2DC'),	
		12 => __('December', 'W2DC'),	
	);
	if ($clicks_data = get_post_meta($object->post->ID, '_clicks_data', true)) {
		$clicks_data = array_filter($clicks_data);
		foreach ($clicks_data AS $month_year=>$count) {
			$month_year = explode('-', $month_year);
			$data[$month_year[1]][$month_year[0]] = $count;
		}
		ksort($data);
	}
	?>
	
	<div class="w2dc-edit-listing-wrapper w2dc-row">
		<?php if ($listing_info): ?>
		<?php w2dc_renderTemplate($info_template, array('object' => $object)); ?>
		<?php endif; ?>
		<div class="w2dc-edit-listing-form w2dc-col-md-<?php echo ($listing_info) ? 9: 12; ?>">

		<?php if (isset($data)): ?>
			<?php foreach ($data AS $year=>$months_counts): ?>
			<h4><?php echo $year; ?></h4>
		
			<div>
				<canvas id="canvas-<?php echo esc_attr($year); ?>" style="height: 450px;"></canvas>
				<script>
					var chartData_<?php echo esc_attr($year); ?> = {
						labels : ["<?php echo implode('","', $months_names); ?>"],
						datasets : [
							{
								fillColor : "rgba(151,187,205,0.2)",
								strokeColor : "rgba(151,187,205,1)",
								<?php
								foreach ($months_names AS $month_num=>$name)
									if (!isset($months_counts[$month_num]))
										$months_counts[$month_num] = 0;
								ksort($months_counts);?>
								data : [<?php echo implode(',', $months_counts); ?>]
							}
						]
					};
		
					(function($) {
						"use strict";
		
						$(function() {
							var ctx_<?php echo esc_attr($year); ?> = document.getElementById("canvas-<?php echo esc_attr($year); ?>").getContext("2d");
							window.myLine_<?php echo esc_attr($year); ?> = new Chart(ctx_<?php echo esc_attr($year); ?>).Bar(chartData_<?php echo esc_attr($year); ?>, {
								responsive: true
							});
						});
					})(jQuery);
				</script>
			</div>
			<hr />
			<?php endforeach; ?>
		<?php endif; ?>
		</div>
	</div>
	
	<a href="<?php echo $frontend_controller->referer; ?>" class="w2dc-btn w2dc-btn-primary"><?php _e('Go back ', 'W2DC'); ?></a>
</div>