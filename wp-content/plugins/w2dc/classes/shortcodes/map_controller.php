<?php 

/**
 *  [webdirectory-map] shortcode
 *
 *
 */
class w2dc_map_controller extends w2dc_frontend_controller {
	
	public $listings_controller;

	public function init($args = array()) {
		global $w2dc_instance;
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'custom_home' => 0,
				'how_to_load' => 'for_map', // full, for_map, for_ajax_map
				//'directories' => '',
				'num' => (!empty($args['custom_home']) && get_option('w2dc_map_markers_is_limit')) ? (int)get_option('w2dc_listings_number_index') : -1,
				'map_markers_is_limit' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_map_markers_is_limit') : 1, // How many map markers to display on the map (when listings shortcode is connected with map by unique string)
				'width' => '',
				'height' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_default_map_height') : 400,
				'radius_circle' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_enable_radius_search_circle') : 1,
				'clusters' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_enable_clusters') : 0,
				'sticky_scroll' => 0,
				'sticky_scroll_toppadding' => 0,
				'show_summary_button' => 0,
				'show_readmore_button' => 1,
				'sticky_featured' => 0,
				'ajax_loading' => 0,
				'ajax_markers_loading' => 0,
				'geolocation' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_enable_geolocation') : 0,
				'start_address' => '',
				'start_latitude' => '',
				'start_longitude' => '',
				'start_zoom' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_start_zoom') : 0,
				'min_zoom' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_map_min_zoom') : 0,
				'max_zoom' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_map_max_zoom') : 0,
				'enable_infowindow' => 1,
				'close_infowindow_out_click' => 1,
				'map_style' => (!empty($args['custom_home'])) ? (int)w2dc_getSelectedMapStyle() : 'default',
				'include_categories_children' => 1,
				'search_on_map' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_search_on_map') : 0,
				'search_on_map_id' => get_option('w2dc_search_map_form_id'),
				'search_on_map_open' => 0,
				'search_on_map_right' => 0,
				'search_on_map_listings' => 'sidebar', // 'sidebar', 'bottom', 'none'
				'radius' => 0,
				'draw_panel' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_enable_draw_panel') : 0,
				'author' => 0,
				'enable_full_screen' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_enable_full_screen') : 1,
				'enable_wheel_zoom' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_enable_wheel_zoom') : 1,
				'enable_dragging_touchscreens' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_enable_dragging_touchscreens') : 1,
				'center_map_onclick' => (!empty($args['custom_home'])) ? (int)get_option('w2dc_center_map_onclick') : 0,
				'categories' => '',
				'locations' => '',
				'tags' => '',
				'related_directory' => 0,
				'related_categories' => 0,
				'related_locations' => 0,
				'related_tags' => 0,
				'related_listing' => 0,
				'ratings' => '',
				'uid' => null,
				'include_get_params' => 1,
		), $args);
		$this->args = apply_filters('w2dc_related_shortcode_args', $shortcode_atts, $args);
		
		// take params from the search string
		if (!empty($this->args['start_address']) && ($address = wcsearch_get_query_string("address"))) {
			$this->args['start_address'] = $address;
			
			if (isset($this->args['radius']) && ($radius = wcsearch_get_query_string("radius"))) {
				$this->args['radius'] = $radius;
			}
		}

		if (isset($this->args['neLat']) && isset($this->args['neLng']) && isset($this->args['swLat']) && isset($this->args['swLng'])) {
			$y1 = $this->args['neLat'];
			$y2 = $this->args['swLat'];
			// when zoom level 2 - there may be problems with neLng and swLng of bounds
			if ($this->args['neLng'] > $this->args['swLng']) {
				$x1 = $this->args['neLng'];
				$x2 = $this->args['swLng'];
			} else {
				$x1 = 180;
				$x2 = -180;
			}
			
			global $wpdb;
			$results = $wpdb->get_results($wpdb->prepare(
				"SELECT DISTINCT
					post_id FROM {$wpdb->w2dc_locations_relationships} AS w2dc_lr
				WHERE MBRContains(
				GeomFromText('Polygon((%f %f,%f %f,%f %f,%f %f,%f %f))'),
				GeomFromText(CONCAT('POINT(',w2dc_lr.map_coords_1,' ',w2dc_lr.map_coords_2,')')))", $y2, $x2, $y2, $x1, $y1, $x1, $y1, $x2, $y2, $x2), ARRAY_A);

			$post_ids = array();
			foreach ($results AS $row) {
				$post_ids[] = $row['post_id'];
			}
			$post_ids = array_unique($post_ids);

			if ($post_ids) {
				if (!empty($this->args['post__in']) && $this->args['post__in'] !== array(0)) {
					$this->args['post__in'] = array_intersect($this->args['post__in'], $post_ids);
					if (empty($this->args['post__in'])) {
						// Do not show any listings
						$this->args['post__in'] = array(0);
					}
				} else {
					$this->args['post__in'] = $post_ids;
				}
			} else {
				// Do not show any listings
				$this->args['post__in'] = array(0);
			}
		}
		
		if (isset($this->args['geo_poly']) && $this->args['geo_poly']) {
			$geo_poly = $this->args['geo_poly'];
			$sql_polygon = array();
			foreach ($geo_poly AS $vertex)
				$sql_polygon[] = $vertex['lat'] . ' ' . $vertex['lng'];
			$sql_polygon[] = $sql_polygon[0];

			// this global array collects locations IDs to display on a map,
			// so radius search will not display markers ourside entered radius
			global $wpdb, $w2dc_address_locations;
			if (function_exists('mysqli_get_server_info') && $wpdb->dbh && version_compare(preg_replace('#[^0-9\.]#', '', mysqli_get_server_info($wpdb->dbh)), '5.6.1', '<')) {
				// below 5.6.1 version
				$thread_stack = @$wpdb->get_row("SELECT @@global.thread_stack", ARRAY_A);
				if ($thread_stack && $thread_stack['@@global.thread_stack'] <= 131072)
					@$wpdb->query("SET @@global.thread_stack = " . 256*1024);

				if (!$wpdb->get_row("SHOW FUNCTION STATUS WHERE name='GISWithin' AND Db='".DB_NAME."'", ARRAY_A))
					$o = $wpdb->query("CREATE FUNCTION GISWithin(pt POINT, mp POLYGON) RETURNS INT(1) DETERMINISTIC
BEGIN
			
DECLARE str, xy TEXT;
DECLARE x, y, p1x, p1y, p2x, p2y, m, xinters DECIMAL(16, 13) DEFAULT 0;
DECLARE counter INT DEFAULT 0;
DECLARE p, pb, pe INT DEFAULT 0;
			
SELECT MBRWithin(pt, mp) INTO p;
IF p != 1 OR ISNULL(p) THEN
RETURN p;
END IF;
			
SELECT X(pt), Y(pt), ASTEXT(mp) INTO x, y, str;
SET str = REPLACE(str, 'POLYGON((','');
SET str = REPLACE(str, '))', '');
SET str = CONCAT(str, ',');
			
SET pb = 1;
SET pe = LOCATE(',', str);
SET xy = SUBSTRING(str, pb, pe - pb);
SET p = INSTR(xy, ' ');
SET p1x = SUBSTRING(xy, 1, p - 1);
SET p1y = SUBSTRING(xy, p + 1);
SET str = CONCAT(str, xy, ',');
			
WHILE pe > 0 DO
SET xy = SUBSTRING(str, pb, pe - pb);
SET p = INSTR(xy, ' ');
SET p2x = SUBSTRING(xy, 1, p - 1);
SET p2y = SUBSTRING(xy, p + 1);
IF p1y < p2y THEN SET m = p1y; ELSE SET m = p2y; END IF;
IF y > m THEN
IF p1y > p2y THEN SET m = p1y; ELSE SET m = p2y; END IF;
IF y <= m THEN
IF p1x > p2x THEN SET m = p1x; ELSE SET m = p2x; END IF;
IF x <= m THEN
IF p1y != p2y THEN
SET xinters = (y - p1y) * (p2x - p1x) / (p2y - p1y) + p1x;
END IF;
IF p1x = p2x OR x <= xinters THEN
SET counter = counter + 1;
END IF;
END IF;
END IF;
END IF;
SET p1x = p2x;
SET p1y = p2y;
SET pb = pe + 1;
SET pe = LOCATE(',', str, pb);
END WHILE;
			
RETURN counter % 2;
			
END;
");
				$results = $wpdb->get_results("SELECT id, post_id FROM {$wpdb->w2dc_locations_relationships} AS w2dc_lr
				WHERE GISWithin(
				GeomFromText(CONCAT('POINT(',w2dc_lr.map_coords_1,' ',w2dc_lr.map_coords_2,')')), PolygonFromText('POLYGON((" . implode(', ', $sql_polygon) . "))'))", ARRAY_A);
			} else {
				// 5.6.1 version or higher
				$results = $wpdb->get_results("SELECT id, post_id FROM {$wpdb->w2dc_locations_relationships} AS w2dc_lr
				WHERE ST_Contains(
				PolygonFromText('POLYGON((" . implode(', ', $sql_polygon) . "))'), GeomFromText(CONCAT('POINT(',w2dc_lr.map_coords_1,' ',w2dc_lr.map_coords_2,')')))", ARRAY_A);
			}

			$post_ids = array();
			$w2dc_address_locations = array();
			foreach ($results AS $row) {
				$post_ids[] = $row['post_id'];
				$w2dc_address_locations[] = $row['id'];
			}
			$post_ids = array_unique($post_ids);
			
			if ($post_ids) {
				if (!empty($this->args['post__in']) && $this->args['post__in'] !== array(0)) {
					$this->args['post__in'] = array_intersect($this->args['post__in'], $post_ids);
					if (empty($this->args['post__in'])) {
						// Do not show any listings
						$this->args['post__in'] = array(0);
					}
				} else {
					$this->args['post__in'] = $post_ids;
				}
			} else {
				// Do not show any listings
				$this->args['post__in'] = array(0);
			}
		}

		$this->map = new w2dc_maps($this->args);
		$this->map->setUniqueId($this->hash);

		if (empty($this->args['ajax_loading'])) {
			// the map shortcode on custom home,
			// all listings locations already collected in directory frontend controller by processQuery() method or in AJAX controller
			if (!$this->args['custom_home'] && !($this->args['uid'] && $listings_controller = $w2dc_instance->getListingsShortcodeByuID($this->args['uid']))) {
				$this->collectLocationsInMap();
			}
		}
		
		apply_filters('w2dc_map_controller_construct', $this);
	}

	public function collectLocationsInMap() {
		
		$listings_args = $this->args;
		
		if (!$this->args['map_markers_is_limit']) {
			$listings_args['onepage'] = 1;
		}
		
		$this->listings_controller = new w2dc_listings_controller();
		$this->listings_controller->init($listings_args);
		$this->listings_controller->hash = $this->hash;
		
		foreach ($this->listings_controller->listings AS $listing) {
			if ($this->args['ajax_markers_loading']) {
				$this->map->collectLocationsForAjax($listing);
			} else {
				$this->map->collectLocations($listing, $this->args['show_summary_button'], $this->args['show_readmore_button']);
			}
		}
	}
	
	public function display() {
		global $w2dc_instance;
		
		if (!is_admin() && !w2dc_is_maps_used()) {
			return;
		}

		$width = false;
		$height = get_option('w2dc_default_map_height');
		if (isset($this->args['width'])) {
			$width = $this->args['width'];
		}
		if (isset($this->args['height'])) {
			$height = $this->args['height'];
		}
		
		$show_summary_button = $this->args['show_summary_button'];
		$show_readmore_button = $this->args['show_readmore_button'];
		
		$map_display_args = array(
				'show_directions' => false,
				'static_image' => false,
				'enable_radius_circle' => $this->args['radius_circle'],
				'enable_clusters' => $this->args['clusters'],
				'show_summary_button' => $show_summary_button,
				'show_readmore_button' => $show_readmore_button,
				'width' => $width,
				'height' => $height,
				'sticky_scroll' => $this->args['sticky_scroll'],
				'sticky_scroll_toppadding' => $this->args['sticky_scroll_toppadding'],
				'map_style' => $this->args['map_style'],
				'search_form' => $this->args['search_on_map'],
				'draw_panel' => $this->args['draw_panel'],
				'custom_home' => $this->args['custom_home'],
				'enable_full_screen' => $this->args['enable_full_screen'],
				'enable_wheel_zoom' => $this->args['enable_wheel_zoom'],
				'enable_dragging_touchscreens' => $this->args['enable_dragging_touchscreens'],
				'center_map_onclick' => $this->args['center_map_onclick'],
				'enable_infowindow' => $this->args['enable_infowindow'],
				'close_infowindow_out_click' => $this->args['close_infowindow_out_click'],
		);
		
		$map_display_args = apply_filters("w2dc_default_map_display_args", $map_display_args);

		ob_start();
		if ($this->args['custom_home'] || ($this->args['uid'] && $listings_controller = $w2dc_instance->getListingsShortcodeByuID($this->args['uid']))) {
			if ($shortcode_controller = $w2dc_instance->getShortcodeProperty(W2DC_MAIN_SHORTCODE)) {
				// the map shortcode on custom home,
				// all listings locations already collected in directory frontend controller by processQuery() method

				if ($shortcode_controller->is_single) {
					$map_display_args['show_summary_button'] = false;
					$map_display_args['show_readmore_button'] = false;
				}

				// map may be disabled for index or excerpt pages in directory settings, so we need to check does this object exist in main shortcode.
				if ($shortcode_controller->map) {
					$shortcode_controller->map->args = array_merge($shortcode_controller->map->args, $this->args);
					
					$shortcode_controller->map->display($map_display_args);
				}
			} elseif (isset($listings_controller) && $listings_controller) {
				// the map shortcode connected with listings shortcode

				
				if (!$listings_controller->map) {
					$listings_controller->map = new w2dc_maps($this->args);
					$listings_controller->map->setUniqueId($this->hash);
					
					if ($this->args['map_markers_is_limit']) {
						// The only map markers of visible listings will be displayed
						foreach ($listings_controller->listings AS $listing) {
							$listings_controller->map->collectLocations($listing, $show_summary_button, $show_readmore_button);
						}
					} elseif ($listings_controller->query) {
						// Display all map markers
						$listings_controller->collectAllLocations();
					}
				}
				$listings_controller->map->display($map_display_args);
			} else {
				// the map shortcode has uID, but listings shortcode does not exist
				
				$this->collectLocationsInMap();
				
				$this->map->display($map_display_args);
			}
		} else {
			// standard behaviour of map shortcode
			
			$this->map->display($map_display_args);
		}

		$output = ob_get_clean();

		wp_reset_postdata();
	
		return $output;
	}
}

?>