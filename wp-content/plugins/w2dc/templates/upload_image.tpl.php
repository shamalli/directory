<div class="w2dc-content w2dc-upload-image-form w2dc-upload-image-form-<?php w2dc_esc_e($upload->input_name); ?>" data-name="<?php w2dc_esc_e($upload->input_name); ?>" data-action-url="<?php w2dc_esc_e($upload->action_url); ?>">
	<div class="w2dc-upload-image w2dc-upload-image-<?php w2dc_esc_e($upload->input_name); ?>" <?php if ($upload->default_url): ?>style="background-image: url(<?php echo esc_url($upload->default_url); ?>);"<?php endif; ?>></div>
	<input type="file" name="browse_file" multiple />
	<input type="hidden" name="w2dc-upload-image-input-<?php w2dc_esc_e($upload->input_name); ?>" class="w2dc-upload-image-input-<?php w2dc_esc_e($upload->input_name); ?>" <?php if ($upload->default_attachment_id): ?>value="<?php w2dc_esc_e($upload->default_attachment_id); ?>"<?php endif; ?> />
	<button class="w2dc-upload-image-button w2dc-btn w2dc-btn-primary"><?php esc_html_e("Upload", "w2dc"); ?></button>
	<button class="w2dc-reset-image-button w2dc-btn w2dc-btn-primary"><?php esc_html_e("Reset", "w2dc"); ?></button>
</div>