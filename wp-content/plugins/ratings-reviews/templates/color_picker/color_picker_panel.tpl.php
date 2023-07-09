	<script>
		(function($) {
			"use strict";

			$(function() {
				<?php $align = (is_rtl() ? 'right' : 'left' ); ?>
				$(document).on('mouseenter', '.w2rr-no-touch #w2rr-color-picker-panel', function () {
					$('#w2rr-color-picker-panel').stop().animate({<?php echo $align; ?>: "0px"}, 500);
				});
				$(document).on('mouseleave', '.w2rr-no-touch #w2rr-color-picker-panel', function () {
					var width = $('#w2rr-color-picker-panel').width() - 50;
					$('#w2rr-color-picker-panel').stop().animate({<?php echo $align; ?>: - width}, 500);
				});
	
				var panel_opened = false;
				$('html').on('click', '.w2rr-touch #w2rr-color-picker-panel-tools', function () {
					if (panel_opened) {
						var width = $('#w2rr-color-picker-panel').width() - 50;
						$('#w2rr-color-picker-panel').stop().animate({<?php echo $align; ?>: - width}, 500);
						panel_opened = false;
					} else {
						$('#w2rr-color-picker-panel').stop().animate({<?php echo $align; ?>: "0px"}, 500);
						panel_opened = true;
					}
				});
			});
		})(jQuery);
	</script>
	<div id="w2rr-color-picker-panel" class="w2rr-content">
		<fieldset id="w2rr-color-picker">
			<label><?php esc_html_e('Choose color palette:', 'W2RR'); ?></label>
			<?php $selected_scheme = (isset($_COOKIE['w2rr_compare_palettes']) ? $_COOKIE['w2rr_compare_palettes'] : get_option('w2rr_color_scheme')); ?>
			<?php w2rr_renderTemplate('color_picker/color_picker_settings.tpl.php', array('selected_scheme' => $selected_scheme)); ?>
			<label><?php printf(esc_html__('Return to the %s', 'W2RR'), '<a href="'.admin_url('admin.php?page=w2rr_settings#_customization').'">backend</a>'); ?></label>
		</fieldset>
		<div id="w2rr-color-picker-panel-tools" class="clearfix">
			<img src="<?php echo W2RR_RESOURCES_URL . 'images/settings.png'; ?>" />
		</div>
	</div>