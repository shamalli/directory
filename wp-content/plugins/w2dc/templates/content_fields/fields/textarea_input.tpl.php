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
		<?php if ($content_field->html_editor): ?>
		<?php wp_editor($content_field->value, 'w2dc-field-input-'.$content_field->id, array('media_buttons' => true, 'editor_class' => 'w2dc-editor-class')); ?>
		<?php else: ?>
		<textarea name="w2dc-field-input-<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-field-input-textarea w2dc-form-control" rows="5"><?php echo esc_textarea($content_field->value); ?></textarea>
		<?php endif; ?>
		<?php if ($content_field->description): ?><p class="description"><?php w2dc_esc_e($content_field->description); ?></p><?php endif; ?>
	</div>
</div>