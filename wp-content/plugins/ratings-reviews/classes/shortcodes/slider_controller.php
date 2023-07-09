<?php 

/**
 *  [webrr-slider] shortcode
 *
 *
 */
class w2rr_slider_controller extends w2rr_frontend_controller {
	public $reviews_controller;

	public function init($args = array()) {
		global $w2rr_instance;
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'slides' => 5,
				'captions' => 1,
				'pager' => 1,
				'width' => '',
				'height' => 0,
				'slide_width' => 0,
				'max_slides' => 1, // max slides in viewport divided by slide_width
				'auto_slides' => 0,
				'auto_slides_delay' => 3000,
				'crop' => 1,
				'order_by_rand' => 0,
		), $args);

		$this->args = $shortcode_atts;

		if ($this->args['slides']) {
			$args['perpage'] = $this->args['slides'];
		}
		
		if ($this->args['order_by_rand']) {
			$args['reviews_order_by'] = 'rand';
		} else {
			$args = array_merge($args, apply_filters('w2rr_order_args', array(), $shortcode_atts, false));
		}

		if (!empty($this->args['post__in'])) {
			if (is_string($this->args['post__in'])) {
				$args = array_merge($args, array('post__in' => explode(',', $this->args['post__in'])));
			} elseif (is_array($this->args['post__in'])) {
				$args['post__in'] = $this->args['post__in'];
			}
		}
		if (!empty($this->args['post__not_in'])) {
			$args = array_merge($args, array('post__not_in' => explode(',', $this->args['post__not_in'])));
		}
		
		$args['with_images'] = 1;
		$args['include_get_params'] = 0;
		
		$this->reviews_controller = new w2rr_reviews_controller();
		$this->reviews_controller->init($args);
		$this->reviews_controller->getItems();
		
		$this->template = 'frontend/slider.tpl.php';

		apply_filters('w2rr_slider_controller_construct', $this);
	}

	public function display() {
		$thumbs = array();
		$images = array();
		while ($this->reviews_controller->query->have_posts()) {
			$this->reviews_controller->query->the_post();
			$review = $this->reviews_controller->reviews[get_the_ID()];
			if ($thumbnail_id = get_post_thumbnail_id(get_the_ID())) {
				$image_src = wp_get_attachment_image_src($thumbnail_id, array(800, 600));
				
				$slider_caption = '';
				if ($this->args['captions']) {
					$slider_caption_addon = '';
					$slider_caption_addon = apply_filters('w2rr_slider_caption', $slider_caption, $review);
					
					$slider_caption = '<div class="w2rr-bx-caption">' . $review->title() . ' <span class="w2rr-slide-rating"><label class="w2rr-rating-icon w2rr-fa w2rr-fa-star"></label>' . $review->getAvgRating() . '</span>' . $slider_caption_addon . '</div>';
				}
					
				$image_tag = '<img src="' . $image_src[0] . '" alt="' . esc_attr($review->title()) . '" title="' . esc_attr($review->title()) . '" />';
				$thumbs[] = '<div class="w2rr-slide-thumb-wrapper">' . $image_tag . '<span class="w2rr-slide-thumb-rating"><label class="w2rr-rating-icon w2rr-fa w2rr-fa-star"></label>' . $review->getAvgRating() . '</span></div>';
				$images[] = '<a href="' . $review->url() . '">' . $image_tag . '</a>' . $slider_caption;
			}
		}
		wp_reset_postdata();

		if ($images) {
			$output =  w2rr_renderTemplate($this->template, array(
					'captions' => 0,
					'slide_width' => $this->args['slide_width'],
					'max_slides' => $this->args['max_slides'],
					'height' => $this->args['height'],
					'auto_slides' => $this->args['auto_slides'],
					'auto_slides_delay' => $this->args['auto_slides_delay'],
					'crop' => $this->args['crop'],
					'images' => $images,
					'thumbs' => $thumbs,
					'pager' => $this->args['pager'],
					'id' => w2rr_generateRandomVal()
			), true);
			
	
			return $output;
		}
	}
}

?>