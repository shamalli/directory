<?php

// @codingStandardsIgnoreFile

?>
<div class="w2dc-demo-prev-next-demos">
	<span class="w2dc-demo-prev-demo"><?php esc_html_e("Prev demo:", "w2dc"); ?> <a href="<?php echo get_permalink($prev_page); ?>"><?php w2dc_esc_e($prev_page->post_title); ?></a></span>
	<span class="w2dc-demo-next-demo"><?php esc_html_e("Next demo:", "w2dc"); ?> <a href="<?php echo get_permalink($next_page); ?>"><?php w2dc_esc_e($next_page->post_title); ?></a></span>
</div>