<?php

// @codingStandardsIgnoreFile

?>
<?php if ($file): ?>
<a href="<?php echo esc_url($file->guid); ?>" target="_blank"><?php if ($content_field->value['text'] && $content_field->use_text) w2dc_esc_e($content_field->value['text']); else echo basename($file->guid); ?></a>
<?php endif; ?>