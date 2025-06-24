<?php

// @codingStandardsIgnoreFile

?>
		<input type="button" id="reset_icon" class="button button-primary button-large" value="<?php esc_attresc_html_e('Reset icon image', 'w2dc'); ?>" />

		<div class="w2dc-icons-theme-block">
		<?php foreach ($locations_icons AS $icon): ?>
			<div class="w2dc-icon" icon_file="<?php w2dc_esc_e($icon); ?>"><img src="<?php echo W2DC_LOCATIONS_ICONS_URL . $icon; ?>" title="<?php w2dc_esc_e($icon); ?>" /></div>
		<?php endforeach;?>
		</div>
		<div class="w2dc-clearfix"></div>