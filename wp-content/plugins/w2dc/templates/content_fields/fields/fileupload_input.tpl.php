<?php

// @codingStandardsIgnoreFile

?>
<div class="w2dc-form-group w2dc-field w2dc-field-input-block w2dc-field-input-block-<?php w2dc_esc_e($content_field->id); ?>">
	<div class="w2dc-col-md-2">
		<label class="w2dc-control-label">
			<?php w2dc_esc_e($content_field->name); ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?>
		</label>
	</div>
	<div class="w2dc-col-md-10">
		<div class="w2dc-row">
			<?php if ($file): ?>
			<div class="w2dc-col-md-6">
				<label><?php esc_html_e('Uploaded file:', 'w2dc'); ?></label>
				<a href="<?php echo esc_url($file->guid); ?>" target="_blank"><?php echo basename($file->guid); ?></a>
				<input type="hidden" name="w2dc-uploaded-file-<?php w2dc_esc_e($content_field->id); ?>" value="<?php w2dc_esc_e($file->ID); ?>" />
				<br />
				<label><input type="checkbox" name="w2dc-reset-file-<?php w2dc_esc_e($content_field->id); ?>" value="1" /> <?php esc_html_e('reset uploaded file', 'w2dc'); ?></label>
			</div>
			<?php endif; ?>
			<div class="w2dc-col-md-6">
				<label><?php esc_html_e('Select file to upload:', 'w2dc'); ?></label>
				<input type="file" name="w2dc-field-input-<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-field-input-fileupload" />
			</div>
			<?php if ($content_field->use_text): ?>
			<div class="w2dc-col-md-12">
				<label><?php esc_html_e('File title:', 'w2dc'); ?></label>
				<input type="text" name="w2dc-field-input-text-<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-field-input-text w2dc-form-control regular-text" value="<?php echo esc_attr($content_field->value['text']); ?>" />
			</div>
			<?php endif; ?>
		</div>
		<?php if ($content_field->description): ?><p class="description"><?php w2dc_esc_e($content_field->description); ?></p><?php endif; ?>
	</div>
</div>