<?php

// @codingStandardsIgnoreFile

?>
<div class="w2dc-content w2dc-map-sidebar <?php if ($search_map->isStickyScroll()) echo 'w2dc-map-sidebar-fixed'; ?>" id="w2dc-map-sidebar-<?php w2dc_esc_e($uid); ?>" style="<?php if (!empty($height)) echo "height: ".$height."px;" ?>" >
	<?php if ($search_map->isSearchForm() && $search_map->isStickyScroll()): ?>
	<?php $search_form->display(); ?>
	<?php endif; ?>
	<?php if ($search_map->isSidebar()): ?>
	<div class="w2dc-map-sidebar-listings-wrapper <?php if ($search_map->isStickyScroll()) echo 'w2dc-map-sidebar-listings-fixed'; ?>" id="w2dc-map-sidebar-listings-wrapper-<?php w2dc_esc_e($uid); ?>">
		<?php if ($search_map->isSearchForm() && !$search_map->isStickyScroll()): ?>
		<?php $search_form->display(); ?>
		<?php endif; ?>
		
		<?php if ($search_map->isListings()): ?>
		<div class="w2dc-map-listings-panel" id="w2dc-map-listings-panel-<?php w2dc_esc_e($uid); ?>">
			<?php echo $search_map->listings_content; ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
<div class="w2dc-map-sidebar-toggle-container w2dc-map-sidebar-toggle-container-<?php w2dc_esc_e($uid); ?>" data-id="<?php w2dc_esc_e($uid); ?>" title="<?php esc_attr_e("Search listings", "w2dc")?>">
	<span class="w2dc-map-sidebar-toggle"></span><span class="w2dc-fa w2dc-fa-search"></span>
</div>
<div class="w2dc-map-sidebar-toggle-container-mobile w2dc-map-sidebar-toggle-container-mobile-<?php w2dc_esc_e($uid); ?>" data-id="<?php w2dc_esc_e($uid); ?>" title="<?php esc_attr_e("Search panel", "w2dc"); ?>">
	<span class="w2dc-map-sidebar-toggle"></span>
</div>