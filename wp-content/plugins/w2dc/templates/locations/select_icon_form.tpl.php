<?php

// @codingStandardsIgnoreFile

?>
<tr class="form-field hide-if-no-js">
	<th scope="row" valign="top"><label for="description"><?php print esc_html_e('Icon', 'w2dc') ?></label></th>
	<td>
		<?php echo $w2dc_instance->locations_manager->choose_icon_link($term->term_id); ?>
		<p class="description"><?php esc_html_e('Associate an icon to this location', 'w2dc'); ?></p>
	</td>
</tr>