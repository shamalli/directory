<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<input type="text" name="<?php w2rr_esc_e($name); ?>" class="vp-input slideinput vp-js-tipsy" original-title="Range between <?php w2rr_esc_e($opt_raw['min']); ?> and <?php w2rr_esc_e($opt_raw['max']); ?>" value="<?php w2rr_esc_e($value); ?>" />
<div class="vp-js-slider slidebar" id="<?php w2rr_esc_e($name); ?>" data-vp-opt="<?php w2rr_esc_e($opt); ?>"></div>

<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_foot'); ?>