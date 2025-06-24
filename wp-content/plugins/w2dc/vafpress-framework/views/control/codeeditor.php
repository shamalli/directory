<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<textarea class="vp-input" name="<?php w2dc_esc_e($name); ?>" class="w2dc-display-none"><?php w2dc_esc_e($value); ?></textarea>
<div class="vp-js-codeeditor" data-vp-opt="<?php w2dc_esc_e($opt); ?>"></div>

<?php if(!$is_compact) echo W2DC_VP_View::instance()->load('control/template_control_foot'); ?>