<div class="w2rr-content">
	<h3><?php echo sprintf(esc_html__('Clicks statistics of the page "%s"', 'w2rr'), $object->title()); ?></h3>
	
	<h4><?php echo sprintf(esc_html__('Click stats: %d', 'w2rr'), (get_post_meta($object->post->ID, '_total_clicks', true) ? get_post_meta($object->post->ID, '_total_clicks', true) : 0)); ?></h4>
	
	<?php 
	$months_names = array(
		1 => esc_html__('January', 'w2rr'),	
		2 => esc_html__('February', 'w2rr'),	
		3 => esc_html__('March', 'w2rr'),	
		4 => esc_html__('April', 'w2rr'),	
		5 => esc_html__('May', 'w2rr'),	
		6 => esc_html__('June', 'w2rr'),	
		7 => esc_html__('July', 'w2rr'),	
		8 => esc_html__('August', 'w2rr'),	
		9 => esc_html__('September', 'w2rr'),	
		10 => esc_html__('October', 'w2rr'),	
		11 => esc_html__('November', 'w2rr'),	
		12 => esc_html__('December', 'w2rr'),	
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
	
	<div class="w2rr-edit-review-wrapper w2rr-row">
		<?php if ($post_info): ?>
		<?php w2rr_renderTemplate($info_template, array('object' => $object)); ?>
		<?php endif; ?>
		<div class="w2rr-edit-review-form w2rr-col-md-<?php echo ($post_info) ? 9: 12; ?>">
		
		<?php if (isset($data)): ?>
			<?php foreach ($data AS $year=>$months_counts): ?>
			<h4><?php echo esc_html($year); ?></h4>
		
			<div>
				<canvas id="canvas-<?php echo esc_attr($year); ?>" class="w2rr-height-450"></canvas>
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
	
	<a href="<?php w2rr_esc_e($frontend_controller->referer); ?>" class="w2rr-btn w2rr-btn-primary"><?php esc_html_e('Go back ', 'w2rr'); ?></a>
</div>