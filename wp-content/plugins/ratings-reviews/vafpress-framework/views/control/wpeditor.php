<?php

// @codingStandardsIgnoreFile

?>
<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_head', $head_info); ?>

<?php
	// prepare value for tinyMCE editor
	$value     = html_entity_decode($value, ENT_COMPAT, 'UTF-8');
	if( has_filter('the_editor_content') )
		$value = apply_filters('the_editor_content', $value);
	else
		$value = wp_richedit_pre($value);
?>
<div class="customEditor">
	<div class="wp-editor-tools">
		<div class="custom_upload_buttons hide-if-no-js wp-media-buttons"><?php do_action( 'media_buttons' ); ?></div>
	</div>
	<textarea class="vp-input vp-js-wpeditor" id="<?php w2rr_esc_e($name . '_ce'); ?>" data-vp-opt="<?php w2rr_esc_e($opt); ?>" rows="10" cols="50" name="<?php w2rr_esc_e($name); ?>" rows="3"><?php w2rr_esc_e($value); ?></textarea>
</div>

<?php if(!$is_compact) echo W2RR_VP_View::instance()->load('control/template_control_foot'); ?>