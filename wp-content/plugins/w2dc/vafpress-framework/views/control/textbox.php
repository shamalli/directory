<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<input type="text" name="<?php w2dc_esc_e($name); ?>" class="vp-input input-large" value="<?php echo esc_attr($value); // do not use w2dc_esc() ?>" />

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>