<div>
	<img class="icon_image_tag w2dc-field-icon" src="<?php if ($icon_file) echo esc_url(W2DC_CATEGORIES_ICONS_URL . $icon_file); ?>" <?php if (!$icon_file): ?>style="display: none;" <?php endif; ?> />
	<input type="hidden" name="icon_image" class="icon_image" value="<?php if ($icon_file) echo esc_attr($icon_file); ?>">
	<input type="hidden" name="category_id" class="category_id" value="<?php echo esc_attr($term_id); ?>">
	<a class="select_icon_image" href="javascript: void(0);"><?php esc_html_e('Select icon', 'w2dc'); ?></a>
</div>