	<div class="w2dc-row w2dc-form-group">
		<label class="w2dc-col-md-12 w2dc-control-label"><?php _e('directions to:', 'W2DC'); ?></label>
		<form action="https://www.waze.com/ul" target="_blank">
			<input type="hidden" name="api" value="1" />
			<div class="w2dc-col-md-12">
				<?php $i = 1; ?>
				<?php foreach ($locations_array AS $location): ?>
				<div class="w2dc-radio">
					<label>
						<input type="radio" name="ll" class="w2dc-select-directions-<?php echo $map_id; ?>" <?php checked($i, 1); ?> value="<?php echo esc_attr($location->map_coords_1.','.$location->map_coords_2); ?>" />
						<?php 
						if ($address = $location->getWholeAddress(false))
							echo $address;
						else 
							echo $location->map_coords_1.' '.$location->map_coords_2;
						?>
					</label>
				</div>
				<?php $i++; ?>
				<?php endforeach; ?>
			</div>
			<div class="w2dc-col-md-12">
				<input class="w2dc-btn w2dc-btn-primary" type="submit" value="<?php esc_attr_e('Get directions', 'W2DC'); ?>" />
			</div>
		</form>
	</div>