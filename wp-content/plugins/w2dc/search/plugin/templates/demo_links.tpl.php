<?php

// @codingStandardsIgnoreFile

?>
<div class="wcsearch-demo-prev-next-demos">
	<span class="wcsearch-demo-prev-demo"><?php esc_html_e("Prev demo:", "wcsearch"); ?> <a href="<?php echo get_permalink($prev_page); ?>"><?php wcsearch_esc_e($prev_page->post_title); ?></a></span>
	<span class="wcsearch-demo-next-demo"><?php esc_html_e("Next demo:", "wcsearch"); ?> <a href="<?php echo get_permalink($next_page); ?>"><?php wcsearch_esc_e($next_page->post_title); ?></a></span>
</div>