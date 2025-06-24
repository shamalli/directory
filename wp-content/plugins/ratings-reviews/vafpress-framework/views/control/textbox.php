<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<input type="text" name="<?php w2rr_esc_e($name); ?>" class="vp-input input-large" value="<?php echo esc_attr($value); ?>" />

<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_foot'); ?>