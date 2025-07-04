<div class="w2rr-upload-image-form w2rr-upload-image-form-<?php echo $upload->input_name; ?>" data-name="<?php echo $upload->input_name; ?>" data-action-url="<?php echo $upload->action_url; ?>">
	<div class="w2rr-upload-image w2rr-upload-image-<?php echo $upload->input_name; ?>" <?php if ($upload->default_url): ?>style="background-image: url(<?php echo esc_url($upload->default_url); ?>);"<?php endif; ?>></div>
	<input type="file" name="browse_file" multiple />
	<input type="hidden" name="w2rr-upload-image-input-<?php echo $upload->input_name; ?>" class="w2rr-upload-image-input-<?php echo $upload->input_name; ?>" <?php if ($upload->default_attachment_id): ?>value="<?php echo $upload->default_attachment_id; ?>"<?php endif; ?> />
	<button class="w2rr-upload-image-button w2rr-btn w2rr-btn-primary"><?php esc_html_e("Upload", "w2rr"); ?></button>
	<button class="w2rr-reset-image-button w2rr-btn w2rr-btn-primary"><?php esc_html_e("Reset", "w2rr"); ?></button>
</div>