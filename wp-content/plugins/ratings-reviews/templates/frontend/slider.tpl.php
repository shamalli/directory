<?php if ($images): ?>
		<style type="text/css">
			<?php if (!empty($height)): ?>
			#w2rr-slider-wrapper-<?php w2rr_esc_e($id); ?> .w2rr-bx-wrapper,
			#w2rr-slider-wrapper-<?php w2rr_esc_e($id); ?> .w2rr-bx-viewport {
				height: <?php w2rr_esc_e($height+10); ?>px !important;
			}
			<?php endif; ?>
			#w2rr-slider-wrapper-<?php w2rr_esc_e($id); ?> .slide img {
				<?php if (!empty($height)): ?>
				height: <?php w2rr_esc_e($height+10); ?>px !important;
				<?php endif; ?>
				object-fit: <?php if (empty($crop)): ?>contain<?php else: ?>cover<?php endif; ?>;
			}
		</style>
		<?php if (count($images) > 1): ?>
		<script>
			(function($) {
				"use strict";

				$(function() {

					var slider_<?php w2rr_esc_e($id); ?> = $("#w2rr-slider-<?php w2rr_esc_e($id); ?>")
					.css("visibility", "hidden")
					.w2rr_bxslider({
						<?php if (!empty($captions)): ?>
						captions: true,
						<?php endif; ?>
						adaptiveHeight: true,
						adaptiveHeightSpeed: 200,
						<?php if (!empty($slide_width)): ?>
						slideWidth: <?php w2rr_esc_e($slide_width); ?>,
						<?php endif; ?>
						<?php if (!empty($max_slides)): ?>
						moveSlides: 1,
						maxSlides: <?php w2rr_esc_e($max_slides); ?>,
						<?php endif; ?>
						nextText: '',
						prevText: '',
						<?php if ($pager && count($thumbs) > 1): ?>
						pagerCustom: '#w2rr-bx-pager-<?php w2rr_esc_e($id); ?>',
						<?php else: ?>
						pager: false,
						<?php endif; ?>
						<?php if (!empty($auto_slides)): ?>
						auto: true,
						autoHover: true,
						pause: <?php w2rr_esc_e($auto_slides_delay); ?>,
						<?php endif; ?>
						onSliderLoad: function(){
							this.css("visibility", "visible");
						},
						preloadImages: 'all'
					});

					$(document).on("w2dc:show_tab", function() {
						slider_<?php w2rr_esc_e($id); ?>.reloadSlider();
					});
				});
			})(jQuery);
		</script>
		<?php endif; ?>
		<div class="w2rr-content w2rr-slider-wrapper" id="w2rr-slider-wrapper-<?php w2rr_esc_e($id); ?>" style="<?php if (!empty($width)): ?>max-width: <?php w2rr_esc_e($width); ?>px; <?php endif; ?>">
			<div class="w2rr-slider" id="w2rr-slider-<?php w2rr_esc_e($id); ?>">
				<?php foreach ($images AS $image): ?>
				<div class="slide"><?php echo $image; ?></div>
				<?php endforeach; ?>
			</div>
			<?php if ($pager && count($thumbs) > 1): ?>
			<div class="w2rr-bx-pager" id="w2rr-bx-pager-<?php w2rr_esc_e($id); ?>">
				<?php foreach ($thumbs AS $index=>$thumb): ?><a data-slide-index="<?php w2rr_esc_e($index); ?>" href=""><?php w2rr_esc_e($thumb); ?></a><?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
<?php endif; ?>