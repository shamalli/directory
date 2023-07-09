<div id="misc-publishing-actions">
	<div class="misc-pub-section">
		<select name="w2rr_post_id">
			<option value=""><?php esc_html_e('- Select a post for review -', 'W2RR'); ?></option>
			<?php foreach ($posts as $target_post): ?>
			<option value="<?php echo esc_attr($target_post->ID); ?>" <?php selected($target_post->ID, $selected_post_id); ?>><?php echo esc_html($target_post->post_title); ?> (ID:<?php echo $target_post->ID; ?>)</option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php if ($selected_post): ?>
	<div class="misc-pub-section">
		<?php echo edit_post_link(esc_html__('Edit post', 'W2RR'), '', '', $selected_post->ID); ?>
	</div>
	<?php endif; ?>
</div>
	