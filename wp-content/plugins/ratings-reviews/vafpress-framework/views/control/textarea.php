<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<textarea class="vp-input" name="<?php w2rr_esc_e($name); ?>"><?php echo esc_attr($value); ?></textarea>

<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_foot'); ?>