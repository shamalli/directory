<?php

// @codingStandardsIgnoreFile

?>
<div class="wcsearch-search-model-input wcsearch-search-model-input-tax-single-slider" <?php echo $search_model->getOptionsString(); ?>>
	<label class="wcsearch-search-model-input-label"><?php echo esc_html($title); ?></label>
	
	<?php
	wcsearch_print_single_slider_code(
		array(
			'min_max_options' => $min_max_options,
			'values' => $values,
			'slug' => $tax_name,
			'tax' => $tax_name,
			'field_name' => $slug,
			'show_scale' => true,
			'string_label' => "",
		)
	);
	?>
</div>