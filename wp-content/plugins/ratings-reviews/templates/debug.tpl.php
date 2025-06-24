<?php w2rr_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php esc_html_e('Ratings & Reviews Debug', 'w2rr'); ?>
</h2>

<textarea class="w2rr-debug-textarea">
license keys = <?php $w2rr_instance->updater->getDownload_url(true); ?>

<?php
if ($rewrite_rules):
foreach ($rewrite_rules AS $key=>$rule)
echo $key . '
' . $rule . '

';
endif;
?>

image_sizes = <?php var_dump(w2rr_get_registered_image_sizes()); ?>

<?php foreach ($settings AS $setting)
echo $setting['option_name'] . ' = ' . $setting['option_value'] . '

';
?>
</textarea>

<?php w2rr_renderTemplate('admin_footer.tpl.php'); ?>