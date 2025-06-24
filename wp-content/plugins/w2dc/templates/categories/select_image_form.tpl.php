<?php

// @codingStandardsIgnoreFile

?>
<tr class="form-field hide-if-no-js">
	<th scope="row" valign="top"><?php print esc_html_e('Featured Image', 'w2dc') ?></th>
	<td>
		<input type="hidden" name="category_image_attachment_id" id="w2dc-category-image-attachment-id" value="<?php echo esc_attr($attachment_id); ?>">

		<div>
			<img src="<?php w2dc_esc_e($image_url); ?>" id="w2dc-category-image" width="300" <?php if (!$image_url): ?>style="display: none;"<?php endif; ?> />
		</div>

		<div class="options">
			<button id="w2dc-upload-category-featured" class="button" data-title="<?php esc_attr_e("Category Featured Image", "w2dc")?>" data-button="<?php esc_attr_e("Insert", "w2dc"); ?>"><?php _e("Select image", "w2dc"); ?></button>
			<button id="w2dc-remove-category-featured" class="button"><?php esc_html_e("Remove image", "w2dc"); ?></button>
		</div>
	</td>
</tr>