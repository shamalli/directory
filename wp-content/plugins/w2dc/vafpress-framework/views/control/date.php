<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<input <?php echo "data-vp-opt='" . $opt . "'"; ?> type="text" name="<?php w2dc_esc_e($name); ?>" class="vp-input vp-js-datepicker" />

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>