<?php if ($images_number): ?>
<script>
	var w2rr_media_metabox_attrs = <?php echo json_encode(
		array(
			'object_id' => $object_id,
			'images_number' => $images_number,
			'images_input_placeholder' => esc_attr__('optional image title', 'W2RR'),
			'images_logo_enabled' => ($logo_enabled) ? 1 : 0,
			'images_input_label' => esc_attr__('set this image as logo', 'W2RR'),
			'images_remove_title' => esc_attr__('remove', 'W2RR'),
			'images_remove_image_nonce' => wp_create_nonce('remove_image'),
			'images_fileupload_url' => admin_url('admin-ajax.php?action=w2rr_upload_image&post_id='.$object_id.'&_wpnonce='.wp_create_nonce('upload_images')),
			'images_is_admin' => (is_admin() && current_user_can('upload_files')) ? 1 : 0,
			'images_upload_image_nonce' => wp_create_nonce('upload_images'),
			'images_upload_image_title' => esc_js(sprintf(__('Upload image (%d maximum)', 'W2RR'), $images_number)),
			'images_upload_image_button' => esc_js(__('Insert', 'W2RR')),
		)
	); ?>;
</script>

<div id="w2rr-images-upload-wrapper" class="w2rr-content w2rr-media-upload-wrapper <?php echo esc_attr($classes); ?>">
	<input type="hidden" id="w2rr-attached-images-order" name="attached_images_order" value="<?php echo implode(',', array_keys($images)); ?>">
	<h4><?php esc_html_e('Attach images', 'W2RR'); ?></h4>

	<div id="w2rr-attached-images-wrapper">
		<?php foreach ($images AS $attachment_id=>$attachment): ?>
		<?php $src = wp_get_attachment_image_src($attachment_id, array(250, 250)); ?>
		<?php $src_full = wp_get_attachment_image_src($attachment_id, 'full'); ?>
		<?php $metadata = wp_get_attachment_metadata($attachment_id); ?>
		<?php $metadata['size'] = size_format(filesize(get_attached_file($attachment_id))); ?>
		<div class="w2rr-attached-item w2rr-move-label">
			<input type="hidden" name="attached_image_id[]" class="w2rr-attached-item-id" value="<?php echo esc_attr($attachment_id); ?>" />
			<a href="<?php echo esc_url($src_full[0]); ?>" data-w2rr_lightbox="review_images" class="w2rr-attached-item-img" style="background-image: url('<?php echo esc_url($src[0]); ?>')"></a>
			<div class="w2rr-attached-item-input">
				<input type="text" name="attached_image_title[]" class="w2rr-form-control" value="<?php esc_attr($attachment['post_title']); ?>" placeholder="<?php esc_html_e('optional image title', 'W2RR'); ?>" />
			</div>
			<?php if ($logo_enabled): ?>
			<div class="w2rr-attached-item-logo w2rr-radio">
				<label>
					<input type="radio" name="attached_image_as_logo" value="<?php echo esc_attr($attachment_id); ?>" <?php checked($logo_image, $attachment_id); ?>> <?php esc_html_e('set this image as logo', 'W2RR'); ?>
				</label>
			</div>
			<?php endif; ?>
			<div class="w2rr-attached-item-delete w2rr-fa w2rr-fa-trash-o" title="<?php esc_attr_e("delete", "W2RR"); ?>"></div>
			<div class="w2rr-attached-item-metadata"><?php echo esc_html($metadata['size']); ?> (<?php echo esc_html($metadata['width']); ?> x <?php echo esc_html($metadata['height']); ?>)</div>
		</div>
		<?php endforeach; ?>
		<?php if (!is_admin()): ?>
		<div class="w2rr-upload-item">
			<div class="w2rr-drop-attached-item">
				<div class="w2rr-drop-zone">
					<?php esc_html_e("Drop here", "W2RR"); ?>
					<button class="w2rr-upload-item-button w2rr-btn w2rr-btn-primary"><?php esc_html_e("Browse", "W2RR"); ?></button>
					<input type="file" name="browse_file" multiple />
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="w2rr-clearfix"></div>

	<?php if (is_admin() && current_user_can('upload_files')): ?>
	<div id="w2rr-admin-upload-functions">
		<div class="w2rr-upload-option">
			<input
				type="button"
				id="w2rr-admin-upload-image"
				class="w2rr-btn w2rr-btn-primary"
				value="<?php esc_attr_e('Upload image', 'W2RR'); ?>" />
		</div>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>