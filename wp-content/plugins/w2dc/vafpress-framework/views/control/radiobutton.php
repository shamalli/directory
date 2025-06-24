<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<?php foreach ($items as $item): ?>
<label>
	<?php $checked = ($item->value == $value); ?>
	<input <?php if($checked) echo 'checked'; ?> class="vp-input<?php if($checked) echo " checked"; ?>" type="radio" name="<?php w2dc_esc_e($name); ?>" value="<?php w2dc_esc_e($item->value); ?>" />
	<span></span><?php w2dc_esc_e($item->label); ?>
</label>
<?php endforeach; ?>

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>