<?php

// @codingStandardsIgnoreFile

?>
<div class="w2dc-form-group w2dc-field w2dc-field-input-block w2dc-field-input-block-<?php w2dc_esc_e($content_field->id); ?>">
	<div class="w2dc-col-md-2">
		<label class="w2dc-control-label">
			<?php w2dc_esc_e($content_field->name); ?> <?php w2dc_esc_e($content_field->currency_symbol); ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?>
		</label>
	</div>
	<div class="w2dc-col-md-10">
		<input type="text" name="w2dc-field-input-<?php w2dc_esc_e($content_field->id); ?>" class="w2dc-field-input-price w2dc-form-control" value="<?php echo esc_attr($content_field->value); ?>" size="4" />
		<?php if ($content_field->description): ?><p class="description"><?php w2dc_esc_e($content_field->description); ?></p><?php endif; ?>
	</div>
</div>