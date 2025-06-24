<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<select multiple name="<?php w2dc_esc_e($name); ?>" class="vp-input vp-js-sorter" data-vp-opt="<?php w2dc_esc_e($opt); ?>">
	<?php
	$labels = array();
	foreach ($items as $item) $labels[$item->value] = $item->label;
	?>

	<?php foreach ($value as $v): ?>
	<option selected value="<?php w2dc_esc_e($v); ?>"><?php echo esc_html($labels[$v]); ?></option>
	<?php unset($labels[$v]); endforeach; ?>

	<?php foreach ($labels as $i => $label): ?>
	<option value="<?php w2dc_esc_e($i); ?>"><?php echo esc_html($label); ?></option>
	<?php endforeach; ?>
</select>

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>