<?php

// @codingStandardsIgnoreFile

?>
		<input type="button" id="reset_icon" class="w2dc-btn w2dc-btn-primary" value="<?php esc_attr_e('Reset icon image', 'w2dc'); ?>" />

		<div class="w2dc-icons-theme-block">
		<?php foreach ($categories_icons AS $icon): ?>
			<div class="w2dc-icon" icon_file="<?php w2dc_esc_e($icon); ?>"><img src="<?php echo W2DC_CATEGORIES_ICONS_URL . $icon; ?>" title="<?php w2dc_esc_e($icon); ?>" /></div>
		<?php endforeach;?>
		</div>
		<div class="w2dc-clearfix"></div>