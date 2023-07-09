<?php

class w2dc_item_listing {
	public $name = 'listing';
	public $item_id;
	
	public function __construct($item_id) {
		$this->item_id = $item_id;
	}
	
	public function getItem() {
		$listing_id = $this->item_id;

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$listing_id = apply_filters('wpml_object_id', $listing_id, W2DC_POST_TYPE, true);
		}
		
		$listing = new w2dc_listing();
		if ($listing->loadListingFromPost($listing_id)) {
			return $listing;
		} else {
			return false;
		}
	}
	
	public function getItemLink() {
		if (($listing = $this->getItem()) && w2dc_current_user_can_edit_listing($listing->post->ID)) {
			if (current_user_can('edit_published_posts')) {
				return '<a href="' . w2dc_get_edit_listing_link($listing->post->ID) . '">' . $listing->title() . '</a>';
			} else { 
				return $listing->title();
			}
		} else {
			return __('N/A', 'W2DC');
		}
	}
	
	public function getItemId() {
		if ($listing = $this->getItem()) {
			return $listing->post->ID;
		} else {
			return __('N/A', 'W2DC');
		}
	}

	public function getItemEditLink() {
		if ($listing = $this->getItem()) {
			$listing_id = $listing->post->ID;
			return '<a href="' . apply_filters('w2dc_get_edit_listing_link', get_edit_post_link($listing_id), $listing_id) . '">' . $listing->title() . '</a>';
		} else {
			return __('N/A', 'W2DC');
		}
	}
	
	public function getItemOptions() {
		if ($listing = $this->getItem()) {
			return array('active_interval' => $listing->level->active_interval, 'active_period' => $listing->level->active_period);
		} else {
			return __('N/A', 'W2DC');
		}
	}
	
	public function getItemOptionsString() {
		if ($listing = $this->getItem()) {
			return __('Listing level - ', 'W2DC') . $listing->level->name . '; ' . __('Active period - ', 'W2DC') . $listing->level->getActivePeriodString();
		} else {
			return __('N/A', 'W2DC');
		}
	}

	public function complete() {
		if ($listing = $this->getItem()) {
			return $listing->processActivate(false);
		}
	}
}

function getInvoicesByListingId($listing_id) {
	$listing = new w2dc_listing();
	if (!$listing->loadListingFromPost($listing_id)) {
		return false;
	}

	$children = get_children(array('post_parent' => $listing_id, 'post_type' => W2DC_INVOICE_TYPE, 'post_status' => 'publish'));

	$invoices = array();
	if (is_array($children) && count($children) > 0)
		foreach ($children as $child) {
		$invoice = new w2dc_invoice();
		$invoice->post = $child;
		$invoice->init();
		$invoices[] = $invoice;
	}
	return $invoices;
}

function getLastInvoiceByListingId($listing_id) {
	if ($invoices = getInvoicesByListingId($listing_id)) {
		return array_shift($invoices);
	} else {
		return false;
	}
}

// Apply payment link
add_action('w2dc_listing_status_option', 'w2dc_pay_invoice_link');
function w2dc_pay_invoice_link($listing) {
	global $w2dc_instance;
	
	if ($listing->post->post_author == get_current_user_id() && ($listing->status == 'unpaid' || $listing->status == 'expired')) {
		if (($invoice = getLastInvoiceByListingId($listing->post->ID)) && w2dc_current_user_can_edit_listing($invoice->post->ID) && current_user_can('edit_published_posts')) {
			echo '<br /><a href="' . w2dc_get_edit_invoice_link($invoice->post->ID) . '" title="' . esc_attr($invoice->post->post_title) . '">' . __('pay invoice', 'W2DC') . '</a>';
		} elseif (!is_admin() && $w2dc_instance->listings_packages->can_user_create_listing_in_level($listing->level->id)) {
			$title = esc_attr(strip_tags($w2dc_instance->listings_packages->available_listings_descr($listing->level->id, __('renew', 'W2DC'))));
			echo '<br /><a href="' . add_query_arg('apply_listing_payment', $listing->post->ID) . '" title="' . $title . '">' . __('apply payment', 'W2DC') . '</a>';
		}
	}
}

add_filter('w2dc_listing_creation', 'w2dc_create_new_listing_invoice');
add_filter('w2dc_listing_creation_front', 'w2dc_create_new_listing_invoice');
function w2dc_create_new_listing_invoice($listing) {
	if ($listing) {
		if (recalcPrice($listing->level->price) > 0) {
			$invoice_args = array(
					'item' => 'listing',
					'title' => sprintf(__('Invoice for activation of listing: %s', 'W2DC'), $listing->title()),
					'is_subscription' => ($listing->level->eternal_active_period) ? false : true,
					'price' => $listing->level->price,
					'item_id' => $listing->post->ID,
					'author_id' => $listing->post->post_author
			);
			if ($invoice_id = call_user_func_array('w2dc_create_invoice', $invoice_args)) {
				w2dc_addMessage(__('New invoice was created successfully, listing will become active after payment', 'W2DC'));
				update_post_meta($listing->post->ID, '_listing_status', 'unpaid');
				if ($listing->post->post_status != 'pending') {
					global $wpdb;
					
					// wp_update_post() can fall into inifinite loop on certain occasions
					$wpdb->query("UPDATE {$wpdb->posts} SET post_status='pending' WHERE ID={$listing->post->ID}");
				}
	
				if (is_user_logged_in() && w2dc_current_user_can_edit_listing($invoice_id) && $edit_invoice_link = w2dc_get_edit_invoice_link($invoice_id, 'url')) {
					wp_redirect(apply_filters('redirect_post_location', $edit_invoice_link, $invoice_id));
					die();
				}
			}
		}
	}
	return $listing;
}

add_filter('w2dc_listing_renew', 'w2dc_renew_listing_invoice', 10, 3);
function w2dc_renew_listing_invoice($continue, $listing, $continue_invoke_hooks) {
	if ($continue_invoke_hooks[0]) {
		if (($invoice = getLastInvoiceByListingId($listing->post->ID)) && $invoice->status == 'unpaid') {
			if (is_user_logged_in() && w2dc_current_user_can_edit_listing($invoice->post->ID) && !is_admin()) {
				wp_redirect(apply_filters('redirect_post_location', w2dc_get_edit_invoice_link($invoice->post->ID, 'url'), $invoice->post->ID));
				die();
			}
			return false;
		} else {
			if (recalcPrice($listing->level->price) > 0) {
				$invoice_args = array(
						'item' => 'listing',
						'title' => sprintf(__('Invoice for renewal of listing: %s', 'W2DC'), $listing->title()),
						'is_subscription' => ($listing->level->eternal_active_period) ? false : true,
						'price' => $listing->level->price,
						'item_id' => $listing->post->ID,
						'author_id' => $listing->post->post_author
				);
				if ($invoice_id = call_user_func_array('w2dc_create_invoice', $invoice_args)) {
					if (is_user_logged_in()) {
						w2dc_addMessage(sprintf(__('New <a href="%s">invoice</a> was created successfully, listing will become active after payment', 'W2DC'), w2dc_get_edit_invoice_link($invoice_id, 'url')));
					}
	
					if ($listing->status == 'expired') {
						update_post_meta($listing->post->ID, '_listing_status', 'unpaid');
					}
	
					return false;
				}
			} else
				return $continue;
		}
	}

	return $continue;
}

// expire listing when level change
/* add_filter('w2dc_listing_level_change_after_expiration', 'w2dc_listing_level_change_after_expiration');
function w2dc_listing_level_change_after_expiration($listing) {

	if (recalcPrice($listing->level->price) > 0) {
		$listing->makeExpired();
	}
} */

?>