<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<textarea class="vp-input" name="<?php w2dc_esc_e($name); ?>"><?php echo esc_attr($value); // do not use w2dc_esc() ?></textarea>

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>