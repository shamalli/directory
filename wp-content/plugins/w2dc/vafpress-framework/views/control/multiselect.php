<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<select multiple name="<?php w2dc_esc_e($name); ?>" class="vp-input vp-js-select2vp" autocomplete="off">
	<?php foreach ($items as $item): ?>
	<option <?php if(in_array($item->value, $value)) echo "selected" ?> value="<?php w2dc_esc_e($item->value); ?>"><?php w2dc_esc_e($item->label); ?></option>
	<?php endforeach; ?>
</select>

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>