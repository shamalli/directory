<script>
	var w2dc_locations_metabox_attrs = <?php echo json_encode(
		array(
			'post_id' => $listing->post->ID,
			'locations_number' => $listing->level->locations_number,
			'is_map_markers' => ($listing->level->map && $listing->level->map_markers) ? 1 : 0,
			'is_map' => ($listing->level->map) ? 1 : 0,
			'images_dialog_title' => esc_js(esc_html__('Select map marker icon', 'w2dc')),
			'icons_dialog_title' => esc_js(esc_html__('Select map marker icon', 'w2dc') . ((get_option('w2dc_map_markers_type') == 'icons') ? esc_html__(' (icon and color may depend on selected categories)', 'w2dc') : '')),
		)
	); ?>;
</script>

<div class="w2dc-locations-metabox w2dc-content">
	<div id="w2dc-locations-wrapper" class="w2dc-form-horizontal">
		<?php
		if ($listing->locations)
			foreach ($listing->locations AS $location)
				w2dc_renderTemplate('locations/locations_in_metabox.tpl.php', array('listing' => $listing, 'location' => $location, 'locations_levels' => $locations_levels, 'delete_location_link' => (count($listing->locations) > 1) ? true : false));
		else
			w2dc_renderTemplate('locations/locations_in_metabox.tpl.php', array('listing' => $listing, 'location' => new w2dc_location, 'locations_levels' => $locations_levels, 'delete_location_link' => false));
		?>
	</div>
	
	<?php if ($listing->level->locations_number > 1): ?>
	<div class="w2dc-row w2dc-form-group w2dc-location-input">
		<div class="w2dc-col-md-12">	
			<a class="add_address w2dc-display-none" href="javascript: void(0);">
				<span class="w2dc-fa w2dc-fa-plus"></span>
				<?php esc_html_e('Add address', 'w2dc'); ?>
			</a>
		</div>
	</div>
	<?php endif; ?>

	<?php if (get_option("w2dc_map_type") != "none" && $listing->level->map): ?>
	<div class="w2dc-row w2dc-form-group w2dc-location-input">
		<div class="w2dc-col-md-12">
			<input type="hidden" name="map_zoom" class="w2dc-map-zoom" value="<?php w2dc_esc_e($listing->map_zoom); ?>" />
			<input type="button" class="w2dc-btn w2dc-btn-primary" onClick="w2dc_generateMap_backend(); return false;" value="<?php esc_attr_e('Generate on the map', 'w2dc'); ?>" />
		</div>
	</div>
	<div class="w2dc-map-canvas w2dc-width-auto w2dc-height-450" id="w2dc-map-canvas"></div>
	<?php endif;?>
</div>