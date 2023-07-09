(function($) {
	"use strict";
	
	$(function() {
		w2rr_check_support();
		w2rr_custom_input_controls();
		w2rr_add_body_classes();
		w2rr_hint();
		w2rr_dashboard_tabs();
		w2rr_tooltips();
		w2rr_ratings();
		w2rr_review_votes();
		w2rr_load_comments();
		w2rr_upload_image();
		w2rr_equalColumnsHeight();
		w2rr_media_metabox();
	});
	
	window.w2rr_check_support = function() {
		
		$(".w2rr-license-support-checker").each(function() {
			
			var el 		= $(this);
			var nonce	= el.data("nonce");
			
			$.ajax({
				type: 'POST',
				url: w2rr_js_objects.ajaxurl,
				data: { 
					'action': 'w2rr_license_support_checker',
					'security': nonce
				},
				success: function(response) {
					
					if (response) {
						el.html(response);
					}
				}
			});
		});
	}
	
	window.w2rr_media_metabox = function() {
		if ($('#w2rr-images-upload-wrapper').length) {

			window.w2rr_image_attachment_tpl = function(attachment_id, uploaded_file, title, size, width, height) {
				var image_attachment_tpl = '<div class="w2rr-attached-item w2rr-move-label">' +
						'<input type="hidden" name="attached_image_id[]" class="w2rr-attached-item-id" value="'+attachment_id+'" />' +
						'<a href="'+uploaded_file+'" data-w2rr_lightbox="listing_images" class="w2rr-attached-item-img" style="background-image: url('+uploaded_file+')"></a>' +
						'<div class="w2rr-attached-item-input">' +
							'<input type="text" name="attached_image_title[]" class="w2rr-form-control" value="" placeholder="' + w2rr_media_metabox_attrs.images_input_placeholder + '" />' +
						'</div>';
						if (w2rr_media_metabox_attrs.images_logo_enabled) {
							image_attachment_tpl = image_attachment_tpl + '<div class="w2rr-attached-item-logo w2rr-radio">' +
							'<label>' +
								'<input type="radio" name="attached_image_as_logo" value="'+attachment_id+'"> ' + w2rr_media_metabox_attrs.images_input_label +
							'</label>' +
							'</div>';
						}
						image_attachment_tpl = image_attachment_tpl + '<div class="w2rr-attached-item-delete w2rr-fa w2rr-fa-trash-o" title="' + w2rr_media_metabox_attrs.images_remove_title + '"></div>' +
						'<div class="w2rr-attached-item-metadata">'+size+' ('+width+' x '+height+')</div>' +
					'</div>';

				return image_attachment_tpl;
			};

			window.w2rr_update_images_attachments_order = function() {
				$("#w2rr-attached-images-order").val($(".w2rr-attached-item-id").map(function() {
					return $(this).val();
				}).get());
			}
			window.w2rr_check_images_attachments_number = function() {
				if (w2rr_media_metabox_attrs.images_number > $("#w2rr-images-upload-wrapper .w2rr-attached-item").length) {
					if (w2rr_js_objects.is_admin) {
						$("#w2rr-admin-upload-functions").show();
					} else {
						$(".w2rr-upload-item").show();
					}
					return true;
				} else {
					if (w2rr_js_objects.is_admin) {
						$("#w2rr-admin-upload-functions").hide();
					} else {
						$(".w2rr-upload-item").hide();
					}
					return false;
				}
			}

			
		    var sortable_images = $("#w2rr-attached-images-wrapper").sortable({
			    delay: 50,
		    	placeholder: "ui-sortable-placeholder",
		    	items: ".w2rr-attached-item",
				helper: function(e, ui) {
					ui.children().each(function() {
						$(this).width($(this).width());
					});
					return ui;
				},
				start: function(e, ui){
					ui.placeholder.width(ui.item.width());
					ui.placeholder.height(ui.item.height());
				},
				update: function( event, ui ) {
					w2rr_update_images_attachments_order();
				}
			});

		    // disable sortable on android, otherwise it breaks click events on image, radio and delete button
		    var ua = navigator.userAgent.toLowerCase();
		    if (ua.indexOf("android") > -1) {
				sortable_images.sortable("disable");
			};

			w2rr_check_images_attachments_number();

			$("#w2rr-attached-images-wrapper").on("click", ".w2rr-attached-item-delete", function() {
				$(this).parents(".w2rr-attached-item").remove();
				
				$.ajax({
					url: w2rr_js_objects.ajaxurl,
					type: "POST",
					dataType: "json",
					data: {
						action: 'w2rr_remove_image',
						post_id: w2rr_media_metabox_attrs.object_id,
						attachment_id: $(this).parent().find(".w2rr-attached-item-id").val(),
						_wpnonce: w2rr_media_metabox_attrs.images_remove_image_nonce
					}
				});
		
				w2rr_check_images_attachments_number();
				w2rr_update_images_attachments_order();
			});

			if (!w2rr_js_objects.is_admin) {
				$(document).on("click", ".w2rr-upload-item-button", function(e){
					e.preventDefault();
					
					$(this).parent().find("input").click();
				});
	
				$('.w2rr-upload-item').fileupload({
					sequentialUploads: true,
					dataType: 'json',
					url: w2rr_media_metabox_attrs.images_fileupload_url,
					dropZone: $('.w2rr-drop-attached-item'),
					add: function (e, data) {
						if (w2rr_check_images_attachments_number()) {
							var jqXHR = data.submit();
						} else {
							return false;
						}
					},
					send: function (e, data) {
						w2rr_add_iloader_on_element($(this).find(".w2rr-drop-attached-item"));
					},
					done: function(e, data) {
						var result = data.result;
						if (result.uploaded_file) {
							var size = result.metadata.size;
							var width = result.metadata.width;
							var height = result.metadata.height;
							$(this).before(w2rr_image_attachment_tpl(result.attachment_id, result.uploaded_file, data.files[0].name, size, width, height));
							w2rr_custom_input_controls();
						} else {
							$(this).find(".w2rr-drop-attached-item").append("<p>"+result.error_msg+"</p>");
						}
						$(this).find(".w2rr-drop-zone").show();
						w2rr_delete_iloader_from_element($(this).find(".w2rr-drop-attached-item"));
						
						w2rr_check_images_attachments_number();
						w2rr_update_images_attachments_order();
					}
				});
			}
			
			if (w2rr_media_metabox_attrs.images_is_admin) {
				$('body').on('click', '#w2rr-admin-upload-image', function(event) {
					event.preventDefault();
			
					var frame = wp.media({
						title : w2rr_media_metabox_attrs.images_upload_image_title,
						multiple : true,
						library : { type : 'image'},
						button : { text : w2rr_media_metabox_attrs.images_upload_image_button},
					});
					frame.on('select', function() {
						var selected_images = [];
						var selection = frame.state().get('selection');
						selection.each(function(attachment) {
							attachment = attachment.toJSON();
							if (attachment.type == 'image') {
					
								if (w2rr_check_images_attachments_number()) {
									w2rr_ajax_loader_show();
			
									$.ajax({
										type: "POST",
										async: false,
										url: w2rr_js_objects.ajaxurl,
										data: {
											'action': 'w2rr_upload_media_image',
											'attachment_id': attachment.id,
											'post_id': w2rr_media_metabox_attrs.object_id,
											'_wpnonce': w2rr_media_metabox_attrs.images_upload_image_nonce,
										},
										attachment_id: attachment.id,
										attachment_url: attachment.sizes.full.url,
										attachment_title: attachment.title,
										dataType: "json",
										success: function (response_from_the_action_function) {
											if (response_from_the_action_function != 0) {
												var size = response_from_the_action_function.metadata.size;
												var width = response_from_the_action_function.metadata.width;
												var height = response_from_the_action_function.metadata.height;
												$("#w2rr-attached-images-wrapper").append(w2rr_image_attachment_tpl(this.attachment_id, this.attachment_url, this.attachment_title, size, width, height));
												w2rr_check_images_attachments_number();
												w2rr_update_images_attachments_order();
											}
												
											w2rr_ajax_loader_hide();
										}
									});
								}
							}
						
						});
					});
					frame.open();
				});
			}
		}
	}
	
	window.w2rr_equalColumnsHeight = function() {
		setTimeout(function(){
			$(".w2rr-reviews-grid.w2rr-reviews-grid-no-masonry .w2rr-review, .w2rr-mobile-reviews-grid-2.w2rr-reviews-grid-no-masonry .w2rr-review").css('height', '');

			var currentTallest = 0;
			var currentRowStart = 0;
			var rowDivs = new Array();
			var $el;
			var topPosition = 0;
			$(".w2rr-reviews-grid.w2rr-reviews-grid-no-masonry .w2rr-review, .w2rr-mobile-reviews-grid-2.w2rr-reviews-grid-no-masonry .w2rr-review").each(function() {
				$el = $(this);
				if (!$el.hasClass("w2rr-mobile-reviews-grid-1")) {
					var topPostion = $el.position().top;
					if (currentRowStart != topPostion) {
						for (var currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
							rowDivs[currentDiv].height(currentTallest);
						}
						rowDivs.length = 0;
						currentRowStart = topPostion;
						currentTallest = $el.height();
						rowDivs.push($el);
					} else {
						rowDivs.push($el);
						currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
					}
					for (var currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
						rowDivs[currentDiv].height(currentTallest);
					}
				}
			});
		}, 500);
	}
	
	window.w2rr_upload_image = function() {
		$(document).on("click", ".w2rr-reset-image-button", function(e){
			e.preventDefault();
			
			var form = $(this).parents(".w2rr-upload-image-form");
			form.parent().find(".w2rr-upload-image").css("background-image", "");
			form.parent().find('.w2rr-upload-image-input-' + form.data('name')).val("");
		});
		if (w2rr_js_objects.is_admin) {
			$(document).on('click', '.w2rr-upload-image-button', function(event) {
				event.preventDefault();
		
				var form = $(this).parents(".w2rr-upload-image-form");
				var frame = wp.media({
					title : w2rr_js_objects.media_dialog_title,
					multiple : false,
					library : { type : 'image'},
					button : { text : w2rr_js_objects.media_dialog_button_text},
				});
				frame.on('select', function() {
					var selected_images = [];
					var selection = frame.state().get('selection');
					selection.each(function(attachment) {
						attachment = attachment.toJSON();
						if (attachment.type == 'image') {
							
							var image_url = attachment.sizes.full.url;
							var attachment_id = attachment.id;
							form.find('.w2rr-upload-image').css("background-image", "url(" + image_url + ")");
							form.find('.w2rr-upload-image-input-' + form.data('name')).val(attachment_id);
						}
					
					});
				});
				frame.open();
			});
		} else {
			$(document).on("click", ".w2rr-upload-image-button", function(e){
				e.preventDefault();
				
				$(this).parent().find("input").click();
			});
			$('.w2rr-upload-image-form').each(function() {
				var form = $(this);
				var action_url = form.data('action-url');
				form.fileupload({
					dataType: 'json',
					url: action_url,
					send: function (e, data) {
						w2rr_add_iloader_on_element(form);
					},
					done: function(e, data) {
						var result = data.result;
						if (result.uploaded_file) {
							var size = result.metadata.size;
							var width = result.metadata.width;
							var height = result.metadata.height;
							form.find('.w2rr-upload-image').css("background-image", "url(" + result.uploaded_file + ")");
							form.find('.w2rr-upload-image-input-' + form.data('name')).val(result.attachment_id);
						} else {
							form.find('.w2rr-upload-image').append("<p>"+result.error_msg+"</p>");
						}
						w2rr_delete_iloader_from_element(form);
					}
				});
			});
		}
	}

	window.w2rr_add_body_classes = function() {
		if ("ontouchstart" in document.documentElement)
			$("body").addClass("w2rr-touch");
		else
			$("body").addClass("w2rr-no-touch");
	}

	window.w2rr_hint = function () {
		$("a.w2rr-hint-icon").each(function() {
			$(this).w2rr_popover({
				trigger: "hover",
				//trigger: "manual",
				container: $(this).parents(".w2rr-content")
			});
		});
	}
	
	window.w2rr_dashboard_tabs = function() {
		$('body').on('click', ".w2rr-dashboard-tabs.nav-tabs li", function(e) {
			window.location = $(this).find("a").attr("href");
		});
	}
	
	window.w2rr_tooltips = function() {
		$('[data-toggle="w2rr-tooltip"]').w2rr_tooltip({
			 trigger : 'hover'
		});
	}
	
	window.w2rr_ratings = function() {
		$('body').on('click', '.w2rr-rating-active .w2rr-rating-icon', function() {
			var rating = $(this).parent(".w2rr-rating-stars");
			var rating_wrapper = $(this).parents(".w2rr-rating-wrapper");
			
			if (!rating.hasClass('w2rr-rating-active-noajax')) {
				rating_wrapper.fadeTo(2000, 0.3);
				
				$.ajax({
		        	url: w2rr_js_objects.ajaxurl,
		        	type: "POST",
		        	dataType: "json",
		            data: {
		            	action: 'w2rr_save_rating',
		            	rating: $(this).data("rating"),
		            	post_id: rating.data("post"),
		            	_wpnonce: rating.data("nonce")
		            },
		            rating_wrapper: rating_wrapper,
		            success: function(response_from_the_action_function){
		            	if (response_from_the_action_function != 0 && response_from_the_action_function.html) {
		            		this.rating_wrapper
		            		.replaceWith(response_from_the_action_function.html)
		            		.fadeIn("fast");
		            	}
		            }
		        });
			} else {
				var rating_value = $(this).data("rating");
				rating.find('.w2rr-rating-noajax-value').val(rating_value);
				rating.find('.w2rr-rating-icon').each(function() {
					$(this).removeClass('w2rr-fa-star w2rr-fa-star-o')
					if ($(this).data("rating") <= rating_value) {
						$(this).addClass('w2rr-fa-star');
					} else {
						$(this).addClass('w2rr-fa-star-o');
					}
				});
			}
		});
	}
	window.w2rr_review_votes = function() {
		$('body').on('click', '.w2rr-review-votes-button', function() {
			var review_id = $(this).data("review");
			var nonce = $(this).data("nonce");
			var vote = ($(this).hasClass("w2rr-review-votes-button-up")) ? 'up' : 'down';

			$.ajax({
				url: w2rr_js_objects.ajaxurl,
				type: "POST",
				dataType: "json",
				data: {
					action: 'w2rr_review_vote',
					vote: vote,
					post_id: review_id,
					_wpnonce: nonce
				},
				vote_button: $(this),
				vote_counter_up: $(this).parent().find(".w2rr-review-votes-counter-up"),
				vote_counter_down: $(this).parent().find(".w2rr-review-votes-counter-down"),
				success: function(response_from_the_action_function){
					if (response_from_the_action_function) {
						this.vote_button.parent().find(".w2rr-review-votes-button").addClass("w2rr-review-votes-button-inactive");
						this.vote_button.removeClass("w2rr-review-votes-button-inactive");
						
						this.vote_counter_up.html(response_from_the_action_function.votes_up);
						this.vote_counter_down.html(response_from_the_action_function.votes_down);
					}
				}
			});
		});
	}
	
	window.w2rr_process_reviews_ajax_response = function(response_from_the_action_function, do_replace) {
		var response_hash = response_from_the_action_function.hash;
		if (response_from_the_action_function) {
			var reviews_block = $('#w2rr-controller-'+response_hash);
			if (do_replace) {
				reviews_block.replaceWith(response_from_the_action_function.html);
			} else {
				reviews_block.find(".w2rr-reviews-block-content").append(response_from_the_action_function.html);
			}
			w2rr_ajax_loader_target_hide("w2rr-controller-"+response_hash);
		}
		w2rr_ajax_loader_target_hide('w2rr-controller-'+response_hash);
	}
	$('body').on('click', '.w2rr-reviews-orderby-link', function(e) {
		e.preventDefault();

		var href = $(this).attr('href');
		var controller_hash = $(this).data('controller-hash');
		var reviews_args_array;
		if (reviews_args_array = w2rr_get_controller_args_array(controller_hash)) {
			var post_params = $.extend({}, reviews_args_array);
			var ajax_params = {'action': 'w2rr_reviews_controller_request', 'reviews_order_by': $(this).data('orderby'), 'reviews_order': $(this).data('order'), 'paged': 1, 'hash': controller_hash};
			for (var attrname in ajax_params) { post_params[attrname] = ajax_params[attrname]; }
			
			window.history.pushState("", "", href);

			w2rr_ajax_loader_target_show($('#w2rr-controller-'+controller_hash));
			$.post(
				w2rr_js_objects.ajaxurl,
				post_params,
				function(response_from_the_action_function) {
					w2rr_process_reviews_ajax_response(response_from_the_action_function, true);
				},
				'json'
			);
		}
	});

	$('body').on('click', '.w2rr-reviews-block .w2rr-pagination li.w2rr-active a', function(e) {
		e.preventDefault();
	});
	$('body').on('click', '.w2rr-reviews-block .w2rr-pagination li a', function(e) {
		if ($(this).data('controller-hash')) {
			e.preventDefault();

			var href = $(this).attr('href');
			var controller_hash = $(this).data('controller-hash');
			var paged = $(this).data('page');
			var reviews_args_array;
			if (reviews_args_array = w2rr_get_controller_args_array(controller_hash)) {
				var post_params = $.extend({}, reviews_args_array);

				var ajax_params = {'action': 'w2rr_reviews_controller_request', 'paged': paged, 'hash': controller_hash};
				for (var attrname in ajax_params) { post_params[attrname] = ajax_params[attrname]; }
						
				var anchor = $('#w2rr-controller-'+controller_hash);
				
				window.history.pushState("", "", href);
				
				w2rr_ajax_loader_target_show($('#w2rr-controller-'+controller_hash), anchor);
				$.post(
					w2rr_js_objects.ajaxurl,
					post_params,
					function(response_from_the_action_function) {
						w2rr_process_reviews_ajax_response(response_from_the_action_function, true);
					},
					'json'
				);
			}
		}
	});
	
	var w2rr_show_more_button_processing = false;
	$(window).scroll(function() {
		$('.w2rr-show-more-button.w2rr-scrolling-paginator').each(function() {
			if ($(window).scrollTop() + $(window).height() > $(this).position().top) {
				if (!w2rr_show_more_button_processing) {
					w2rr_callShowMoreReviews($(this));
				}
			}
		});
	});
	$('body').on('click', '.w2rr-show-more-button', function(e) {
		e.preventDefault();
		w2rr_callShowMoreReviews($(this));
	});
	var w2rr_callShowMoreReviews = function(button) {
		var controller_hash = button.data("controller-hash");
		var reviews_args_array;
		if (reviews_args_array = w2rr_get_controller_args_array(controller_hash)) {
			w2rr_add_iloader_on_element(button);

			var post_params = $.extend({}, reviews_args_array);
			if (typeof post_params.paged != 'undefined')
				var paged = parseInt(post_params.paged)+1;
			else
				var paged = 2;
			reviews_args_array.paged = paged;
			
			var existing_reviews = '';
			$("#w2rr-controller-"+controller_hash+" .w2rr-reviews-block-content article").each(function(index) {
				existing_reviews = $(this).attr("id").replace("post-", "") + "," + existing_reviews;
			});

			var ajax_params = {'action': 'w2rr_reviews_controller_request', 'do_append': 1, 'paged': paged, 'existing_reviews': existing_reviews, 'hash': controller_hash};
			for (var attrname in ajax_params) { post_params[attrname] = ajax_params[attrname]; }

			w2rr_show_more_button_processing = true;
			$.post(
				w2rr_js_objects.ajaxurl,
				post_params,
				w2rr_completeAJAXShowMore(button),
				'json'
			);
		}
	}
	var w2rr_completeAJAXShowMore = function(button) {
		return function(response_from_the_action_function) {
			w2rr_process_reviews_ajax_response(response_from_the_action_function, false, false, false);
			w2rr_show_more_button_processing = false;
			w2rr_delete_iloader_from_element(button);
			if (response_from_the_action_function.hide_show_more_reviews_button) {
				button.hide();
			}
		}
	}

	window.w2rr_custom_input_controls = function() {
		// Custom input controls
		$(".w2rr-checkbox label, .w2rr-radio label").each(function() {
			if (!$(this).find(".w2rr-control-indicator").length) {
				$(this).append($("<div>").addClass("w2rr-control-indicator"));
			}
		});
		
		var slider_input_controls = function(el) {
			var sheet = document.createElement('style');
			document.body.appendChild(sheet);
			
			var prefs = ['webkit-slider-runnable-track', 'moz-range-track', 'ms-track'];
			
			var id = $(el).attr('id');
			var slider_color = $('#'+id).css("background-color");
			var curVal = parseInt(el.value);
			var rating = (curVal + 1) / 2;
			var gradientVal = (curVal - 1) * 12.5;
			var style = '';

			$('.w2rr-range-slider-labels.'+id+' li').removeClass('w2rr-range-slider-labels-active w2rr-range-slider-labels-selected');
			var curLabel = $('.w2rr-range-slider-labels.'+id).find('li:nth-child(' + curVal + ')');
			curLabel.addClass('w2rr-range-slider-labels-active w2rr-range-slider-labels-selected');
			curLabel.prevAll().addClass('w2rr-range-slider-labels-selected');

			$('.w2rr-range-slider-value.'+id).html(rating);
			
			var gradient_destination = 'to right';
			if (w2rr_js_objects.is_rtl) {
				gradient_destination = 'to left';
			}

			for (var i = 0; i < prefs.length; i++) {
				style += '#'+id+'::-' + prefs[i] + '{background: linear-gradient(' + gradient_destination + ', ' + slider_color + ' 0%, ' + slider_color + ' ' + gradientVal + '%, #f0f0f0 ' + gradientVal + '%, #f0f0f0 100%)}';
			}
			sheet.textContent = style;
			
			var sum = 0;
			$('.w2rr-range-slider-value').each(function() {
				sum += Number($(this).text());
			});
			var avg = Math.round(sum/$('.w2rr-range-slider-value').length*10)/10;
			var avg_percents = Math.round(((sum/$('.w2rr-range-slider-value').length)-1)*25);
			$('.w2rr-progress-circle span').text(avg.toFixed(1));
			$('.w2rr-progress-circle').removeClass().addClass('w2rr-progress-circle').addClass('p'+avg_percents);
			if (avg_percents > 50) {
				$('.w2rr-progress-circle').addClass('w2rr-over50');
			}
		}
		$(".w2rr-range-slider-input").each(function () {
			slider_input_controls(this);
		});
		$(".w2rr-range-slider-input").on('input', function () {
			slider_input_controls(this);
		});
		$('.w2rr-range-slider-labels li').on('click', function () {
			var index = $(this).index();
			var input = $(this).parents('.w2rr-range-slider').find('.w2rr-range-slider-input');
			input.val(index + 1).trigger('input');
		});
	}
	$(document).ajaxComplete(function(event, xhr, settings) {
		if (typeof w2rr_js_objects != "undefined") {
			if (settings.url === w2rr_js_objects.ajaxurl) {
				w2rr_custom_input_controls();
			}
		}
	});
	
	$.fn.swipeDetector = function (options) {
		// States: 0 - no swipe, 1 - swipe started, 2 - swipe released
		var swipeState = 0;
		// Coordinates when swipe started
		var startX = 0;
		var startY = 0;
		// Distance of swipe
		var pixelOffsetX = 0;
		var pixelOffsetY = 0;
		// Target element which should detect swipes.
		var swipeTarget = this;
		var defaultSettings = {
				// Amount of pixels, when swipe don't count.
				swipeThreshold: 70,
				// Flag that indicates that plugin should react only on touch events.
				// Not on mouse events too.
				useOnlyTouch: false
		};

		// Initializer
		(function init() {
			options = $.extend(defaultSettings, options);
			// Support touch and mouse as well.
			swipeTarget.on('mousedown touchstart', swipeStart);
			$('html').on('mouseup touchend', swipeEnd);
			$('html').on('mousemove touchmove', swiping);
		})();

		function swipeStart(event) {
			if (options.useOnlyTouch && !event.originalEvent.touches)
				return;

			if (event.originalEvent.touches)
				event = event.originalEvent.touches[0];

			if (swipeState === 0) {
				swipeState = 1;
				startX = event.clientX;
				startY = event.clientY;
			}
		}

		function swipeEnd(event) {
			if (swipeState === 2) {
				swipeState = 0;

				if (Math.abs(pixelOffsetX) > Math.abs(pixelOffsetY) &&
						Math.abs(pixelOffsetX) > options.swipeThreshold) { // Horizontal Swipe
					if (pixelOffsetX < 0) {
						swipeTarget.trigger($.Event('swipeLeft.sd'));
					} else {
						swipeTarget.trigger($.Event('swipeRight.sd'));
					}
				} else if (Math.abs(pixelOffsetY) > options.swipeThreshold) { // Vertical swipe
					if (pixelOffsetY < 0) {
						swipeTarget.trigger($.Event('swipeUp.sd'));
					} else {
						swipeTarget.trigger($.Event('swipeDown.sd'));
					}
				}
			}
		}

		function swiping(event) {
			// If swipe don't occuring, do nothing.
			if (swipeState !== 1) 
				return;

			if (event.originalEvent.touches) {
				event = event.originalEvent.touches[0];
			}

			var swipeOffsetX = event.clientX - startX;
			var swipeOffsetY = event.clientY - startY;

			if ((Math.abs(swipeOffsetX) > options.swipeThreshold) ||
					(Math.abs(swipeOffsetY) > options.swipeThreshold)) {
				swipeState = 2;
				pixelOffsetX = swipeOffsetX;
				pixelOffsetY = swipeOffsetY;
			}
		}

		return swipeTarget; // Return element available for chaining.
	}
	
	// AJAX Comments scripts
	window.w2rr_comments_ajax_load_template = function(params, my_global) {
        var my_global;
        var request_in_process = false;

        params.action = "w2rr_comments_load_template";

        $.ajax({
        	url: w2rr_js_objects.ajaxurl,
        	type: "POST",
        	dataType: "html",
            data: params,
            global: my_global,
            success: function( msg ){
                $(params.target_div).fadeIn().html(msg);
                request_in_process = false;
                if (typeof params.callback === "function") {
                    params.callback();
                }
            }
        });
    }
    $(document).on('submit', '#w2rr_default_add_comment_form', function(e) {
       e.preventDefault();

       var $this = $(this);
       $this.css('opacity', '0.5');

       var data = {
           action: "w2rr_comments_add_comment",
           post_id: $('#w2rr_comments_ajax_handle').data('post_id'),
           user_name: $('#w2rr_comments_user_name').val(),
           user_email: $('#w2rr_comments_user_email').val(),
           user_url: $('#w2rr_comments_user_url').val(),
           comment: $('#comment').val(),
           comment_parent: $('#comment_parent').val(),
           security: $('#w2rr_comments_nonce').val()
       };

       $.ajax({
        	url: w2rr_js_objects.ajaxurl,
        	type: "POST",
        	dataType: "html",
            data: data,
            global: false,
            success: function( msg ){
                w2rr_comments_ajax_load_template({
                    "target_div": "#w2rr_comments_ajax_target",
                    "template": $('#w2rr_comments_ajax_handle').attr('data-template'),
                    "post_id": $('#w2rr_comments_ajax_handle').attr('data-post_id'),
                    "security": $('#w2rr_comments_nonce').val()
                }, false );
                $('textarea').val('');
                $this.css('opacity', '1');
            }
        });
    });
    $(document).on('keypress', '#w2rr_default_add_comment_form textarea, #w2rr_default_add_comment_form input', function(e) {
        if (e.keyCode == '13') {
            e.preventDefault();
            $('#w2rr_default_add_comment_form').submit();
        }
    });
    window.w2rr_load_comments = function() {
        if ($('#w2rr_comments_ajax_handle').length) {

            var data = {
                "action": "w2rr_comments_load_template",
                "target_div": "#w2rr_comments_ajax_target",
                "template": $('#w2rr_comments_ajax_handle').data('template'),
                "post_id": $('#w2rr_comments_ajax_handle').data('post_id'),
                "security": $('#w2rr_comments_nonce').val()
            };

            $.ajax({
            	url: w2rr_js_objects.ajaxurl,
            	type: "POST",
            	dataType: "html",
                data: data,
                success: function(msg){
                    $("#w2rr_comments_ajax_target").fadeIn().html(msg); // Give a smooth fade in effect
                    if (window.location.hash && $(window.location.hash).length){
                        $('html, body').animate({
                            scrollTop: $(window.location.hash).offset().top
                        });
                        //$(window.location.hash).addClass('w2rr-comments-highlight');
                    }
                }
            });

            $(document).on('click', '.w2rr-comments-time-handle', function(e) {
                $('.w2rr-comments-content').removeClass('w2rr-comments-highlight')
                comment_id = '#comment-' + $(this).attr('data-comment_id');
                $(comment_id).addClass('w2rr-comments-highlight');
            });
        }
    };
    $(document).on('click', '#w2rr_cancel_reply', function(e) {
    	$('#comment_parent').val(0);
    	$('#w2rr-comments-leave-comment-label').html(w2rr_js_objects.leave_comment);
    });
    $(document).on('click', '.w2rr-comment-reply', function(e) {
    	var comment_id = $(this).data("comment-id");
    	var comment_author = $(this).data("comment-author");
    	$('#comment_parent').val(comment_id);
    	$('#w2rr-comments-leave-comment-label').html(w2rr_js_objects.leave_reply+" "+comment_author+". <a id='w2rr_cancel_reply' href='javascript: void(0);'>"+w2rr_js_objects.cancel_reply+"</a>");
    });
    $(document).on('click', '.w2rr-comments-more-handle', function(e) {
        e.preventDefault();
        if ($(this).hasClass('w2rr-comments-more-open')) {
            $('a', this).html(w2rr_js_objects.more);
            $('#comment').css('height', '0');
        } else {
            $('a', this).html(w2rr_js_objects.less);
            $('#comment').css('height', '150');
        }
        $(this).toggleClass('w2rr-comments-more-open');
        $('.w2rr-comments-more-container').toggle();
    });
	
	window.w2rr_ajax_loader_target_show = function(target, scroll_to_anchor, offest_top) {
		if (typeof scroll_to_anchor != 'undefined' && scroll_to_anchor) {
			if (typeof offest_top == 'undefined' || !offest_top) {
				var offest_top = 0;
			}
			$('html,body').animate({scrollTop: scroll_to_anchor.offset().top - offest_top}, 'slow');
		}
		var id = target.attr("id");
		if (!$("[data-loader-id='"+id+"']").length) {
			var loader = $('<div data-loader-id="'+id+'" class="w2rr-ajax-target-loading"><div class="w2rr-loader"></div></div>');
			target.prepend(loader);
			loader.css({
				width: target.outerWidth()+10,
				height: target.outerHeight()+10
			});
			if (target.outerHeight() > 600) {
				loader.find(".w2rr-loader").addClass("w2rr-loader-max-top");
			}
		}
	}
	window.w2rr_ajax_loader_target_hide = function(id) {
		$("[data-loader-id='"+id+"']").remove();
	}
	
	window.w2rr_ajax_loader_show = function(msg) {
		var overlay = $('<div id="w2rr-ajax-loader-overlay"><div class="w2rr-loader"></div></div>');
	    $('body').append(overlay);
	}
	
	window.w2rr_ajax_loader_hide = function() {
		$("#w2rr-ajax-loader-overlay").remove();
	}

	window.w2rr_get_controller_args_array = function(hash) {
		if (typeof w2rr_controller_args_array != 'undefined' && Object.keys(w2rr_controller_args_array))
			for (var controller_hash in w2rr_controller_args_array)
				if (controller_hash == hash)
					return w2rr_controller_args_array[controller_hash];
	}
	
	window.w2rr_ajax_iloader = $("<div>", { class: 'w2rr-ajax-iloader' }).html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
	window.w2rr_add_iloader_on_element = function(button) {
		button
		.attr('disabled', 'disabled')
		.wrapInner('<div class="w2rr-hidden"></div>')
		.append(w2rr_ajax_iloader);
	}
	window.w2rr_delete_iloader_from_element = function(button) {
		button.find(".w2rr-hidden").contents().unwrap();
		button.removeAttr('disabled').find(".w2rr-ajax-iloader").remove();
	}
	
	// Select FA icon dialog
	$(document).on("click", ".w2rr-select-fa-icon", function() {
		var dialog_title = $(this).text();
		var icon_image_name = $(this).data("icon-image-name");
		var icon_image_name_obj = $("#"+icon_image_name);
		var icon_tag = $(this).data("icon-tag");
		var icon_tag_obj = $("."+icon_tag);
		
		var icon_click_event;
		var reset_icon_click_event;
		
		var dialog_obj = $('<div id="w2rr-select-fa-icon-dialog"></div>');
		dialog_obj.dialog({
			dialogClass: 'w2rr-content',
			width: ($(window).width()*0.5),
			height: ($(window).height()*0.8),
			modal: true,
			resizable: false,
			draggable: false,
			title: dialog_title,
			open: function() {
				w2rr_ajax_loader_show();
				$.ajax({
					type: "POST",
					url: w2rr_js_objects.ajaxurl,
					data: {'action': 'w2rr_select_fa_icon'},
					dataType: 'html',
					success: function(response_from_the_action_function){
						if (response_from_the_action_function != 0) {
							dialog_obj.html(response_from_the_action_function);
							if (icon_image_name_obj.val()) {
								$("#"+icon_image_name_obj.val()).addClass("w2rr-selected-icon");
							}

							icon_click_event = $(document).one("click", ".w2rr-fa-icon", function() {
								$(".w2rr-selected-icon").removeClass("w2rr-selected-icon");
								icon_image_name_obj.val($(this).attr('id'));
								icon_tag_obj.removeClass().addClass(icon_tag+' w2rr-icon-tag w2rr-fa '+icon_image_name_obj.val());
								icon_tag_obj.show();
								$(this).addClass("w2rr-selected-icon");
								reset_icon_click_event.off("click", "#w2rr-reset-fa-icon");
								dialog_obj.remove();
							});
							reset_icon_click_event = $(document).one("click", "#w2rr-reset-fa-icon", function() {
								$(".w2rr-selected-icon").removeClass("w2rr-selected-icon");
								icon_tag_obj.removeClass().addClass(icon_tag+' w2rr-icon-tag');
								icon_tag_obj.hide();
								icon_image_name_obj.val('');
								icon_click_event.off("click", ".w2rr-fa-icon");
								dialog_obj.remove();
							});
						}
					},
					complete: function() {
						w2rr_ajax_loader_hide();
					}
				});
				$(document).on("click", ".ui-widget-overlay", function() {
					icon_click_event.off("click", ".w2rr-fa-icon");
					reset_icon_click_event.off("click", "#w2rr-reset-fa-icon");
					dialog_obj.remove();
				});
			},
			close: function() {
				icon_click_event.off("click", ".w2rr-fa-icon");
				reset_icon_click_event.off("click", "#w2rr-reset-fa-icon");
				dialog_obj.remove();
			}
		});
	});
	
	$(document).on("click", ".w2rr-delete-single-rating", function() {
		var rating_row = $(this);
		var post_id = $(this).data('post-id');
		var rating_key = $(this).data('rating-key');
		var nonce = $(this).data('nonce');
		
		$.ajax({
			type: "POST",
			url: w2rr_js_objects.ajaxurl,
			data: {
				action: 'w2rr_delete_single_rating',
				post_id: post_id,
				rating_key: rating_key,
				_wpnonce: nonce
			},
			dataType: 'html',
			success: function(response_from_the_action_function){
				if (response_from_the_action_function != 0) {
					rating_row.parents(".w2rr-delete-rating-tr").remove();
				}
			}
		});
	});
	
	window.w2rr_show_review = function(review_id, title) {
		
		if (w2rr_js_objects.single_review_is_on_page) {
			return true;
		}
		
		event.preventDefault(); 
		
		var toppadding = 0;
		
		var swidth = window.innerWidth?window.innerWidth:document.documentElement&&document.documentElement.clientWidth?document.documentElement.clientWidth:document.body.clientWidth;
		var sheight = window.innerHeight?(window.innerHeight-toppadding):document.documentElement&&document.documentElement.clientHeight?(document.documentElement.clientHeight-toppadding):(document.body.clientHeight-toppadding);
		var dialog = $('<div id="w2rr-review-dialog"></div>').dialog({
			width: (swidth < 1000 ? (swidth*0.95) : 1000),
			height: (sheight),
			modal: true,
			resizable: false,
			draggable: false,
			position: { my: "center top-"+toppadding },
			title: title,
			dialogClass: "w2rr-review-dialog",
			open: function() {
				$("html").css({"overflow": "hidden"});
				w2rr_ajax_loader_show();
				$.ajax({
					type: "POST",
					url: w2rr_js_objects.ajaxurl,
					data: {'action': 'w2rr_review_dialog', 'review_id': review_id},
					dataType: 'json',
					success: function(response_from_the_action_function){
						if (response_from_the_action_function) {
							var title = $('<textarea />').html(response_from_the_action_function.review_title).text();
							dialog.dialog("option", "title", title);
							
							$('#w2rr-review-dialog').html(response_from_the_action_function.review_html);
							
							w2rr_tooltips();
							w2rr_custom_input_controls();
							
							// Special trick for lightbox
							if (typeof lightbox != 'undefined') {
								var dataLightboxValue = $("#w2rr-lighbox-images a").data("w2rr-lightbox");
								$("#w2rr-lighbox-images a").removeAttr("data-w2rr-lightbox").attr("data-lightbox", dataLightboxValue);
								$('body').on('click', 'a[data-w2rr-lightbox]', function(event) {
									event.preventDefault();
									var link = $('#w2rr-lighbox-images a[href="'+$(this).attr('href')+'"]');
									lightbox.start(link);
								});
							}
							
							w2rr_load_comments();
							
						} else {
							w2rr_close_review();
						}
					},
					complete: function() {
						w2rr_ajax_loader_hide();
					},
					error: function() {
						w2rr_ajax_loader_hide();
					}
				});
				$(document).on("click", ".ui-widget-overlay", function() {
					$('#w2rr-review-dialog').dialog('close');
				});
				
				$('.ui-dialog-titlebar-close').remove();
				var link = '<span class="w2rr-close-review-dialog w2rr-fa w2rr-fa-close"></span>';
				$(this).parent().find(".ui-dialog-titlebar").append(link);
				$(".w2rr-close-review-dialog").on('click', function () {
					$('#w2rr-review-dialog').dialog('close');
				});
			},
			close: function() {
				w2rr_close_review();
			}
		})
		.on('keydown', function(evt) {
			if (evt.keyCode === $.ui.keyCode.ESCAPE) {
				w2rr_close_review();
			}
			evt.stopPropagation();
		});
		
		return false;
	}
	
	window.w2rr_close_review = function() {
		// Removes hash from URL
		history.pushState("", document.title, window.location.pathname + window.location.search);
		$("html").css("overflow", "auto");
		$("#w2rr-review-dialog").remove();
	}
	
})(jQuery);


function w2rr_make_slug(name) {
	name = name.toLowerCase();
	
	var defaultDiacriticsRemovalMap = [
	                                   {'base':'A', 'letters':/[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g},
	                                   {'base':'AA','letters':/[\uA732]/g},
	                                   {'base':'AE','letters':/[\u00C6\u01FC\u01E2]/g},
	                                   {'base':'AO','letters':/[\uA734]/g},
	                                   {'base':'AU','letters':/[\uA736]/g},
	                                   {'base':'AV','letters':/[\uA738\uA73A]/g},
	                                   {'base':'AY','letters':/[\uA73C]/g},
	                                   {'base':'B', 'letters':/[\u0042\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181]/g},
	                                   {'base':'C', 'letters':/[\u0043\u24B8\uFF23\u0106\u0108\u010A\u010C\u00C7\u1E08\u0187\u023B\uA73E]/g},
	                                   {'base':'D', 'letters':/[\u0044\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779]/g},
	                                   {'base':'DZ','letters':/[\u01F1\u01C4]/g},
	                                   {'base':'Dz','letters':/[\u01F2\u01C5]/g},
	                                   {'base':'E', 'letters':/[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g},
	                                   {'base':'F', 'letters':/[\u0046\u24BB\uFF26\u1E1E\u0191\uA77B]/g},
	                                   {'base':'G', 'letters':/[\u0047\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E]/g},
	                                   {'base':'H', 'letters':/[\u0048\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D]/g},
	                                   {'base':'I', 'letters':/[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g},
	                                   {'base':'J', 'letters':/[\u004A\u24BF\uFF2A\u0134\u0248]/g},
	                                   {'base':'K', 'letters':/[\u004B\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2]/g},
	                                   {'base':'L', 'letters':/[\u004C\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780]/g},
	                                   {'base':'LJ','letters':/[\u01C7]/g},
	                                   {'base':'Lj','letters':/[\u01C8]/g},
	                                   {'base':'M', 'letters':/[\u004D\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C]/g},
	                                   {'base':'N', 'letters':/[\u004E\u24C3\uFF2E\u01F8\u0143\u00D1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4]/g},
	                                   {'base':'NJ','letters':/[\u01CA]/g},
	                                   {'base':'Nj','letters':/[\u01CB]/g},
	                                   {'base':'O', 'letters':/[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g},
	                                   {'base':'OI','letters':/[\u01A2]/g},
	                                   {'base':'OO','letters':/[\uA74E]/g},
	                                   {'base':'OU','letters':/[\u0222]/g},
	                                   {'base':'P', 'letters':/[\u0050\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754]/g},
	                                   {'base':'Q', 'letters':/[\u0051\u24C6\uFF31\uA756\uA758\u024A]/g},
	                                   {'base':'R', 'letters':/[\u0052\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782]/g},
	                                   {'base':'S', 'letters':/[\u0053\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784]/g},
	                                   {'base':'T', 'letters':/[\u0054\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786]/g},
	                                   {'base':'TZ','letters':/[\uA728]/g},
	                                   {'base':'U', 'letters':/[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g},
	                                   {'base':'V', 'letters':/[\u0056\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245]/g},
	                                   {'base':'VY','letters':/[\uA760]/g},
	                                   {'base':'W', 'letters':/[\u0057\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72]/g},
	                                   {'base':'X', 'letters':/[\u0058\u24CD\uFF38\u1E8A\u1E8C]/g},
	                                   {'base':'Y', 'letters':/[\u0059\u24CE\uFF39\u1EF2\u00DD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE]/g},
	                                   {'base':'Z', 'letters':/[\u005A\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762]/g},
	                                   {'base':'a', 'letters':/[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g},
	                                   {'base':'aa','letters':/[\uA733]/g},
	                                   {'base':'ae','letters':/[\u00E6\u01FD\u01E3]/g},
	                                   {'base':'ao','letters':/[\uA735]/g},
	                                   {'base':'au','letters':/[\uA737]/g},
	                                   {'base':'av','letters':/[\uA739\uA73B]/g},
	                                   {'base':'ay','letters':/[\uA73D]/g},
	                                   {'base':'b', 'letters':/[\u0062\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253]/g},
	                                   {'base':'c', 'letters':/[\u0063\u24D2\uFF43\u0107\u0109\u010B\u010D\u00E7\u1E09\u0188\u023C\uA73F\u2184]/g},
	                                   {'base':'d', 'letters':/[\u0064\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A]/g},
	                                   {'base':'dz','letters':/[\u01F3\u01C6]/g},
	                                   {'base':'e', 'letters':/[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g},
	                                   {'base':'f', 'letters':/[\u0066\u24D5\uFF46\u1E1F\u0192\uA77C]/g},
	                                   {'base':'g', 'letters':/[\u0067\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F]/g},
	                                   {'base':'h', 'letters':/[\u0068\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265]/g},
	                                   {'base':'hv','letters':/[\u0195]/g},
	                                   {'base':'i', 'letters':/[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g},
	                                   {'base':'j', 'letters':/[\u006A\u24D9\uFF4A\u0135\u01F0\u0249]/g},
	                                   {'base':'k', 'letters':/[\u006B\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3]/g},
	                                   {'base':'l', 'letters':/[\u006C\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747]/g},
	                                   {'base':'lj','letters':/[\u01C9]/g},
	                                   {'base':'m', 'letters':/[\u006D\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F]/g},
	                                   {'base':'n', 'letters':/[\u006E\u24DD\uFF4E\u01F9\u0144\u00F1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5]/g},
	                                   {'base':'nj','letters':/[\u01CC]/g},
	                                   {'base':'o', 'letters':/[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g},
	                                   {'base':'oi','letters':/[\u01A3]/g},
	                                   {'base':'ou','letters':/[\u0223]/g},
	                                   {'base':'oo','letters':/[\uA74F]/g},
	                                   {'base':'p','letters':/[\u0070\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755]/g},
	                                   {'base':'q','letters':/[\u0071\u24E0\uFF51\u024B\uA757\uA759]/g},
	                                   {'base':'r','letters':/[\u0072\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783]/g},
	                                   {'base':'s','letters':/[\u0073\u24E2\uFF53\u00DF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B]/g},
	                                   {'base':'t','letters':/[\u0074\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787]/g},
	                                   {'base':'tz','letters':/[\uA729]/g},
	                                   {'base':'u','letters':/[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g},
	                                   {'base':'v','letters':/[\u0076\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C]/g},
	                                   {'base':'vy','letters':/[\uA761]/g},
	                                   {'base':'w','letters':/[\u0077\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73]/g},
	                                   {'base':'x','letters':/[\u0078\u24E7\uFF58\u1E8B\u1E8D]/g},
	                                   {'base':'y','letters':/[\u0079\u24E8\uFF59\u1EF3\u00FD\u0177\u1EF9\u0233\u1E8F\u00FF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF]/g},
	                                   {'base':'z','letters':/[\u007A\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763]/g}
	                               ];
	for(var i=0; i<defaultDiacriticsRemovalMap.length; i++)
		name = name.replace(defaultDiacriticsRemovalMap[i].letters, defaultDiacriticsRemovalMap[i].base);

	//change spaces and other characters by '_'
	name = name.replace(/\W/gi, "_");
	// remove double '_'
	name = name.replace(/(\_)\1+/gi, "_");
	
	return name;
}

function w2rr_in_array(val, arr) 
{
	for (var i = 0; i < arr.length; i++) {
		if (arr[i] == val)
			return i;
	}
	return false;
}

function w2rr_find_get_parameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}


/*!
 * jQuery Mousewheel 3.1.13 -------------------------------------------------------------------------------------------------------------------------------------------
 *
 * Copyright 2015 jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){function b(b){var g=b||window.event,h=i.call(arguments,1),j=0,l=0,m=0,n=0,o=0,p=0;if(b=a.event.fix(g),b.type="mousewheel","detail"in g&&(m=-1*g.detail),"wheelDelta"in g&&(m=g.wheelDelta),"wheelDeltaY"in g&&(m=g.wheelDeltaY),"wheelDeltaX"in g&&(l=-1*g.wheelDeltaX),"axis"in g&&g.axis===g.HORIZONTAL_AXIS&&(l=-1*m,m=0),j=0===m?l:m,"deltaY"in g&&(m=-1*g.deltaY,j=m),"deltaX"in g&&(l=g.deltaX,0===m&&(j=-1*l)),0!==m||0!==l){if(1===g.deltaMode){var q=a.data(this,"mousewheel-line-height");j*=q,m*=q,l*=q}else if(2===g.deltaMode){var r=a.data(this,"mousewheel-page-height");j*=r,m*=r,l*=r}if(n=Math.max(Math.abs(m),Math.abs(l)),(!f||f>n)&&(f=n,d(g,n)&&(f/=40)),d(g,n)&&(j/=40,l/=40,m/=40),j=Math[j>=1?"floor":"ceil"](j/f),l=Math[l>=1?"floor":"ceil"](l/f),m=Math[m>=1?"floor":"ceil"](m/f),k.settings.normalizeOffset&&this.getBoundingClientRect){var s=this.getBoundingClientRect();o=b.clientX-s.left,p=b.clientY-s.top}return b.deltaX=l,b.deltaY=m,b.deltaFactor=f,b.offsetX=o,b.offsetY=p,b.deltaMode=0,h.unshift(b,j,l,m),e&&clearTimeout(e),e=setTimeout(c,200),(a.event.dispatch||a.event.handle).apply(this,h)}}function c(){f=null}function d(a,b){return k.settings.adjustOldDeltas&&"mousewheel"===a.type&&b%120===0}var e,f,g=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],h="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],i=Array.prototype.slice;if(a.event.fixHooks)for(var j=g.length;j;)a.event.fixHooks[g[--j]]=a.event.mouseHooks;var k=a.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var c=h.length;c;)this.addEventListener(h[--c],b,!1);else this.onmousewheel=b;a.data(this,"mousewheel-line-height",k.getLineHeight(this)),a.data(this,"mousewheel-page-height",k.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var c=h.length;c;)this.removeEventListener(h[--c],b,!1);else this.onmousewheel=null;a.removeData(this,"mousewheel-line-height"),a.removeData(this,"mousewheel-page-height")},getLineHeight:function(b){var c=a(b),d=c["offsetParent"in a.fn?"offsetParent":"parent"]();return d.length||(d=a("body")),parseInt(d.css("fontSize"),10)||parseInt(c.css("fontSize"),10)||16},getPageHeight:function(b){return a(b).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})});


//jquery.coo_kie.js -------------------------------------------------------------------------------------------------------------------------------------------
jQuery.cookie=function(e,i,o){if("undefined"==typeof i){var n=null;if(document.cookie&&""!=document.cookie)for(var r=document.cookie.split(";"),t=0;t<r.length;t++){var p=jQuery.trim(r[t]);if(p.substring(0,e.length+1)==e+"="){n=decodeURIComponent(p.substring(e.length+1));break}}return n}o=o||{},null===i&&(i="",o.expires=-1);var u="";if(o.expires&&("number"==typeof o.expires||o.expires.toUTCString)){var s;"number"==typeof o.expires?(s=new Date,s.setTime(s.getTime()+24*o.expires*60*60*1e3)):s=o.expires,u="; expires="+s.toUTCString()}var a=o.path?"; path="+o.path:"",c=o.domain?"; domain="+o.domain:"",m=o.secure?"; secure":"";document.cookie=[e,"=",encodeURIComponent(i),u,a,c,m].join("")};


//jquery.w2rr_bxslider.min.js -------------------------------------------------------------------------------------------------------------------------------------------
/**
 * w2rr_bxslider v4.2.1d
 * Copyright 2013-2017 Steven Wanderski
 * Written while drinking Belgian ales and listening to jazz
 * Licensed under MIT (http://opensource.org/licenses/MIT)
 */
!function(t){var e={mode:"horizontal",slideSelector:"",infiniteLoop:!0,hideControlOnEnd:!1,speed:500,easing:null,slideMargin:0,startSlide:0,randomStart:!1,captions:!1,ticker:!1,tickerHover:!1,adaptiveHeight:!1,adaptiveHeightSpeed:500,video:!1,useCSS:!0,preloadImages:"visible",responsive:!0,slideZIndex:50,wrapperClass:"w2rr-bx-wrapper",touchEnabled:!0,swipeThreshold:50,oneToOneTouch:!0,preventDefaultSwipeX:!0,preventDefaultSwipeY:!1,ariaLive:!0,ariaHidden:!0,keyboardEnabled:!1,pager:!0,pagerType:"full",pagerShortSeparator:" / ",pagerSelector:null,buildPager:null,pagerCustom:null,controls:!0,nextText:"Next",prevText:"Prev",nextSelector:null,prevSelector:null,autoControls:!1,startText:"Start",stopText:"Stop",autoControlsCombine:!1,autoControlsSelector:null,auto:!1,pause:4e3,autoStart:!0,autoDirection:"next",stopAutoOnClick:!1,autoHover:!1,autoDelay:0,autoSlideForOnePage:!1,minSlides:1,maxSlides:1,moveSlides:0,slideWidth:0,shrinkItems:!1,onSliderLoad:function(){return!0},onSlideBefore:function(){return!0},onSlideAfter:function(){return!0},onSlideNext:function(){return!0},onSlidePrev:function(){return!0},onSliderResize:function(){return!0},onAutoChange:function(){return!0}};t.fn.w2rr_bxslider=function(n){if(0===this.length)return this;if(this.length>1)return this.each(function(){t(this).w2rr_bxslider(n)}),this;var s={},o=this,r=t(window).width(),a=t(window).height();if(!t(o).data("w2rr_bxslider")){var l=function(){t(o).data("w2rr_bxslider")||(s.settings=t.extend({},e,n),s.settings.slideWidth=parseInt(s.settings.slideWidth),s.children=o.children(s.settings.slideSelector),s.children.length<s.settings.minSlides&&(s.settings.minSlides=s.children.length),s.children.length<s.settings.maxSlides&&(s.settings.maxSlides=s.children.length),s.settings.randomStart&&(s.settings.startSlide=Math.floor(Math.random()*s.children.length)),s.active={index:s.settings.startSlide},s.carousel=s.settings.minSlides>1||s.settings.maxSlides>1,s.carousel&&(s.settings.preloadImages="all"),s.minThreshold=s.settings.minSlides*s.settings.slideWidth+(s.settings.minSlides-1)*s.settings.slideMargin,s.maxThreshold=s.settings.maxSlides*s.settings.slideWidth+(s.settings.maxSlides-1)*s.settings.slideMargin,s.working=!1,s.controls={},s.interval=null,s.animProp="vertical"===s.settings.mode?"top":"left",s.usingCSS=s.settings.useCSS&&"fade"!==s.settings.mode&&function(){for(var t=document.createElement("div"),e=["WebkitPerspective","MozPerspective","OPerspective","msPerspective"],i=0;i<e.length;i++)if(void 0!==t.style[e[i]])return s.cssPrefix=e[i].replace("Perspective","").toLowerCase(),s.animProp="-"+s.cssPrefix+"-transform",!0;return!1}(),"vertical"===s.settings.mode&&(s.settings.maxSlides=s.settings.minSlides),o.data("origStyle",o.attr("style")),o.children(s.settings.slideSelector).each(function(){t(this).data("origStyle",t(this).attr("style"))}),d())},d=function(){var e=s.children.eq(s.settings.startSlide);o.wrap('<div class="'+s.settings.wrapperClass+'"><div class="w2rr-bx-viewport"></div></div>'),s.viewport=o.parent(),s.settings.ariaLive&&!s.settings.ticker&&s.viewport.attr("aria-live","polite"),s.loader=t('<div class="bx-loading" />'),s.viewport.prepend(s.loader),o.css({width:"horizontal"===s.settings.mode?1e3*s.children.length+215+"%":"auto",position:"relative"}),s.usingCSS&&s.settings.easing?o.css("-"+s.cssPrefix+"-transition-timing-function",s.settings.easing):s.settings.easing||(s.settings.easing="swing"),s.viewport.css({width:"100%",overflow:"hidden",position:"relative"}),s.viewport.parent().css({maxWidth:u()}),s.children.css({float:"horizontal"===s.settings.mode?"left":"none",listStyle:"none",position:"relative"}),s.children.css("width",h()),"horizontal"===s.settings.mode&&s.settings.slideMargin>0&&s.children.css("marginRight",s.settings.slideMargin),"vertical"===s.settings.mode&&s.settings.slideMargin>0&&s.children.css("marginBottom",s.settings.slideMargin),"fade"===s.settings.mode&&(s.children.css({position:"absolute",zIndex:0,display:"none"}),s.children.eq(s.settings.startSlide).css({zIndex:s.settings.slideZIndex,display:"block"})),s.controls.el=t('<div class="bx-controls" />'),s.settings.captions&&k(),s.active.last=s.settings.startSlide===f()-1,s.settings.video&&o.fitVids(),"none"===s.settings.preloadImages?e=null:("all"===s.settings.preloadImages||s.settings.ticker)&&(e=s.children),s.settings.ticker?s.settings.pager=!1:(s.settings.controls&&C(),s.settings.auto&&s.settings.autoControls&&T(),s.settings.pager&&b(),(s.settings.controls||s.settings.autoControls||s.settings.pager)&&s.viewport.after(s.controls.el)),null===e?g():c(e,g)},c=function(e,i){var n=e.find('img:not([src=""]), iframe').length,s=0;if(0===n)return void i();e.find('img:not([src=""]), iframe').each(function(){t(this).one("load error",function(){++s===n&&i()}).each(function(){(this.complete||""==this.src)&&t(this).trigger("load")})})},g=function(){if(s.settings.infiniteLoop&&"fade"!==s.settings.mode&&!s.settings.ticker){var e="vertical"===s.settings.mode?s.settings.minSlides:s.settings.maxSlides,i=s.children.slice(0,e).clone(!0).addClass("bx-clone"),n=s.children.slice(-e).clone(!0).addClass("bx-clone");s.settings.ariaHidden&&(i.attr("aria-hidden",!0),n.attr("aria-hidden",!0)),o.append(i).prepend(n)}s.loader.remove(),m(),"vertical"===s.settings.mode&&(s.settings.adaptiveHeight=!0),s.viewport.height(p()),o.redrawSlider(),s.settings.onSliderLoad.call(o,s.active.index),s.initialized=!0,s.settings.responsive&&t(window).on("resize",U),s.settings.auto&&s.settings.autoStart&&(f()>1||s.settings.autoSlideForOnePage)&&L(),s.settings.ticker&&O(),s.settings.pager&&z(s.settings.startSlide),s.settings.controls&&q(),s.settings.touchEnabled&&!s.settings.ticker&&X(),s.settings.keyboardEnabled&&!s.settings.ticker&&t(document).keydown(B)},p=function(){var e=0,n=t();if("vertical"===s.settings.mode||s.settings.adaptiveHeight)if(s.carousel){var o=1===s.settings.moveSlides?s.active.index:s.active.index*x();for(n=s.children.eq(o),i=1;i<=s.settings.maxSlides-1;i++)n=o+i>=s.children.length?n.add(s.children.eq(i-1)):n.add(s.children.eq(o+i))}else n=s.children.eq(s.active.index);else n=s.children;return"vertical"===s.settings.mode?(n.each(function(i){e+=t(this).outerHeight()}),s.settings.slideMargin>0&&(e+=s.settings.slideMargin*(s.settings.minSlides-1))):e=Math.max.apply(Math,n.map(function(){return t(this).outerHeight(!1)}).get()),"border-box"===s.viewport.css("box-sizing")?e+=parseFloat(s.viewport.css("padding-top"))+parseFloat(s.viewport.css("padding-bottom"))+parseFloat(s.viewport.css("border-top-width"))+parseFloat(s.viewport.css("border-bottom-width")):"padding-box"===s.viewport.css("box-sizing")&&(e+=parseFloat(s.viewport.css("padding-top"))+parseFloat(s.viewport.css("padding-bottom"))),e},u=function(){var t="100%";return s.settings.slideWidth>0&&(t="horizontal"===s.settings.mode?s.settings.maxSlides*s.settings.slideWidth+(s.settings.maxSlides-1)*s.settings.slideMargin:s.settings.slideWidth),t},h=function(){var t=s.settings.slideWidth,e=s.viewport.width();if(0===s.settings.slideWidth||s.settings.slideWidth>e&&!s.carousel||"vertical"===s.settings.mode)t=e;else if(s.settings.maxSlides>1&&"horizontal"===s.settings.mode){if(e>s.maxThreshold)return t;e<s.minThreshold?t=(e-s.settings.slideMargin*(s.settings.minSlides-1))/s.settings.minSlides:s.settings.shrinkItems&&(t=Math.floor((e+s.settings.slideMargin)/Math.ceil((e+s.settings.slideMargin)/(t+s.settings.slideMargin))-s.settings.slideMargin))}return t},v=function(){var t=1,e=null;return"horizontal"===s.settings.mode&&s.settings.slideWidth>0?s.viewport.width()<s.minThreshold?t=s.settings.minSlides:s.viewport.width()>s.maxThreshold?t=s.settings.maxSlides:(e=s.children.first().width()+s.settings.slideMargin,t=Math.floor((s.viewport.width()+s.settings.slideMargin)/e)||1):"vertical"===s.settings.mode&&(t=s.settings.minSlides),t},f=function(){var t=0,e=0,i=0;if(s.settings.moveSlides>0){if(!s.settings.infiniteLoop){for(;e<s.children.length;)++t,e=i+v(),i+=s.settings.moveSlides<=v()?s.settings.moveSlides:v();return i}t=Math.ceil(s.children.length/x())}else t=Math.ceil(s.children.length/v());return t},x=function(){return s.settings.moveSlides>0&&s.settings.moveSlides<=v()?s.settings.moveSlides:v()},m=function(){var t,e,i;s.children.length>s.settings.maxSlides&&s.active.last&&!s.settings.infiniteLoop?"horizontal"===s.settings.mode?(e=s.children.last(),t=e.position(),S(-(t.left-(s.viewport.width()-e.outerWidth())),"reset",0)):"vertical"===s.settings.mode&&(i=s.children.length-s.settings.minSlides,t=s.children.eq(i).position(),S(-t.top,"reset",0)):(t=s.children.eq(s.active.index*x()).position(),s.active.index===f()-1&&(s.active.last=!0),void 0!==t&&("horizontal"===s.settings.mode?S(-t.left,"reset",0):"vertical"===s.settings.mode&&S(-t.top,"reset",0)))},S=function(e,i,n,r){var a,l;s.usingCSS?(l="vertical"===s.settings.mode?"translate3d(0, "+e+"px, 0)":"translate3d("+e+"px, 0, 0)",o.css("-"+s.cssPrefix+"-transition-duration",n/1e3+"s"),"slide"===i?(o.css(s.animProp,l),0!==n?o.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(e){t(e.target).is(o)&&(o.off("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),A())}):A()):"reset"===i?o.css(s.animProp,l):"ticker"===i&&(o.css("-"+s.cssPrefix+"-transition-timing-function","linear"),o.css(s.animProp,l),0!==n?o.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(e){t(e.target).is(o)&&(o.off("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),S(r.resetValue,"reset",0),F())}):(S(r.resetValue,"reset",0),F()))):(a={},a[s.animProp]=e,"slide"===i?o.animate(a,n,s.settings.easing,function(){A()}):"reset"===i?o.css(s.animProp,e):"ticker"===i&&o.animate(a,n,"linear",function(){S(r.resetValue,"reset",0),F()}))},w=function(){for(var e="",i="",n=f(),o=0;o<n;o++)i="",s.settings.buildPager&&t.isFunction(s.settings.buildPager)||s.settings.pagerCustom?(i=s.settings.buildPager(o),s.pagerEl.addClass("bx-custom-pager")):(i=o+1,s.pagerEl.addClass("bx-default-pager")),e+='<div class="w2rr-bx-pager-item"><a href="" data-slide-index="'+o+'" class="w2rr-bx-pager-link">'+i+"</a></div>";s.pagerEl.html(e)},b=function(){s.settings.pagerCustom?s.pagerEl=t(s.settings.pagerCustom):(s.pagerEl=t('<div class="w2rr-bx-pager" />'),s.settings.pagerSelector?t(s.settings.pagerSelector).html(s.pagerEl):s.controls.el.addClass("bx-has-pager").append(s.pagerEl),w()),s.pagerEl.on("click touchend","a",I)},C=function(){s.controls.next=t('<a class="w2rr-bx-next" href="">'+s.settings.nextText+"</a>"),s.controls.prev=t('<a class="w2rr-bx-prev" href="">'+s.settings.prevText+"</a>"),s.controls.next.on("click touchend",P),s.controls.prev.on("click touchend",E),s.settings.nextSelector&&t(s.settings.nextSelector).append(s.controls.next),s.settings.prevSelector&&t(s.settings.prevSelector).append(s.controls.prev),s.settings.nextSelector||s.settings.prevSelector||(s.controls.directionEl=t('<div class="w2rr-bx-controls-direction" />'),s.controls.directionEl.append(s.controls.prev).append(s.controls.next),s.controls.el.addClass("bx-has-controls-direction").append(s.controls.directionEl))},T=function(){s.controls.start=t('<div class="bx-controls-auto-item"><a class="bx-start" href="">'+s.settings.startText+"</a></div>"),s.controls.stop=t('<div class="bx-controls-auto-item"><a class="bx-stop" href="">'+s.settings.stopText+"</a></div>"),s.controls.autoEl=t('<div class="bx-controls-auto" />'),s.controls.autoEl.on("click",".bx-start",M),s.controls.autoEl.on("click",".bx-stop",y),s.settings.autoControlsCombine?s.controls.autoEl.append(s.controls.start):s.controls.autoEl.append(s.controls.start).append(s.controls.stop),s.settings.autoControlsSelector?t(s.settings.autoControlsSelector).html(s.controls.autoEl):s.controls.el.addClass("bx-has-controls-auto").append(s.controls.autoEl),D(s.settings.autoStart?"stop":"start")},k=function(){s.children.each(function(e){var i=t(this).find("img:first").attr("title");void 0!==i&&(""+i).length&&t(this).append('<div class="bx-caption"><span>'+i+"</span></div>")})},P=function(t){t.preventDefault(),s.controls.el.hasClass("disabled")||(s.settings.auto&&s.settings.stopAutoOnClick&&o.stopAuto(),o.goToNextSlide())},E=function(t){t.preventDefault(),s.controls.el.hasClass("disabled")||(s.settings.auto&&s.settings.stopAutoOnClick&&o.stopAuto(),o.goToPrevSlide())},M=function(t){o.startAuto(),t.preventDefault()},y=function(t){o.stopAuto(),t.preventDefault()},I=function(e){var i,n;e.preventDefault(),s.controls.el.hasClass("disabled")||(s.settings.auto&&s.settings.stopAutoOnClick&&o.stopAuto(),i=t(e.currentTarget),void 0!==i.attr("data-slide-index")&&(n=parseInt(i.attr("data-slide-index")))!==s.active.index&&o.goToSlide(n))},z=function(e){var i=s.children.length;if("short"===s.settings.pagerType)return s.settings.maxSlides>1&&(i=Math.ceil(s.children.length/s.settings.maxSlides)),void s.pagerEl.html(e+1+s.settings.pagerShortSeparator+i);s.pagerEl.find("a").removeClass("active"),s.pagerEl.each(function(i,n){t(n).find("a").eq(e).addClass("active")})},A=function(){if(s.settings.infiniteLoop){var t="";0===s.active.index?t=s.children.eq(0).position():s.active.index===f()-1&&s.carousel?t=s.children.eq((f()-1)*x()).position():s.active.index===s.children.length-1&&(t=s.children.eq(s.children.length-1).position()),t&&("horizontal"===s.settings.mode?S(-t.left,"reset",0):"vertical"===s.settings.mode&&S(-t.top,"reset",0))}s.working=!1,s.settings.onSlideAfter.call(o,s.children.eq(s.active.index),s.oldIndex,s.active.index)},D=function(t){s.settings.autoControlsCombine?s.controls.autoEl.html(s.controls[t]):(s.controls.autoEl.find("a").removeClass("active"),s.controls.autoEl.find("a:not(.bx-"+t+")").addClass("active"))},q=function(){1===f()?(s.controls.prev.addClass("disabled"),s.controls.next.addClass("disabled")):!s.settings.infiniteLoop&&s.settings.hideControlOnEnd&&(0===s.active.index?(s.controls.prev.addClass("disabled"),s.controls.next.removeClass("disabled")):s.active.index===f()-1?(s.controls.next.addClass("disabled"),s.controls.prev.removeClass("disabled")):(s.controls.prev.removeClass("disabled"),s.controls.next.removeClass("disabled")))},H=function(){o.startAuto()},W=function(){o.stopAuto()},L=function(){s.settings.autoDelay>0?setTimeout(o.startAuto,s.settings.autoDelay):(o.startAuto(),t(window).focus(H).blur(W)),s.settings.autoHover&&o.hover(function(){s.interval&&(o.stopAuto(!0),s.autoPaused=!0)},function(){s.autoPaused&&(o.startAuto(!0),s.autoPaused=null)})},O=function(){var e,i,n,r,a,l,d,c,g=0;"next"===s.settings.autoDirection?o.append(s.children.clone().addClass("bx-clone")):(o.prepend(s.children.clone().addClass("bx-clone")),e=s.children.first().position(),g="horizontal"===s.settings.mode?-e.left:-e.top),S(g,"reset",0),s.settings.pager=!1,s.settings.controls=!1,s.settings.autoControls=!1,s.settings.tickerHover&&(s.usingCSS?(r="horizontal"===s.settings.mode?4:5,s.viewport.hover(function(){i=o.css("-"+s.cssPrefix+"-transform"),n=parseFloat(i.split(",")[r]),S(n,"reset",0)},function(){c=0,s.children.each(function(e){c+="horizontal"===s.settings.mode?t(this).outerWidth(!0):t(this).outerHeight(!0)}),a=s.settings.speed/c,l="horizontal"===s.settings.mode?"left":"top",d=a*(c-Math.abs(parseInt(n))),F(d)})):s.viewport.hover(function(){o.stop()},function(){c=0,s.children.each(function(e){c+="horizontal"===s.settings.mode?t(this).outerWidth(!0):t(this).outerHeight(!0)}),a=s.settings.speed/c,l="horizontal"===s.settings.mode?"left":"top",d=a*(c-Math.abs(parseInt(o.css(l)))),F(d)})),F()},F=function(t){var e,i,n,r=t||s.settings.speed,a={left:0,top:0},l={left:0,top:0};"next"===s.settings.autoDirection?a=o.find(".bx-clone").first().position():l=s.children.first().position(),e="horizontal"===s.settings.mode?-a.left:-a.top,i="horizontal"===s.settings.mode?-l.left:-l.top,n={resetValue:i},S(e,"ticker",r,n)},N=function(e){var i=t(window),n={top:i.scrollTop(),left:i.scrollLeft()},s=e.offset();return n.right=n.left+i.width(),n.bottom=n.top+i.height(),s.right=s.left+e.outerWidth(),s.bottom=s.top+e.outerHeight(),!(n.right<s.left||n.left>s.right||n.bottom<s.top||n.top>s.bottom)},B=function(t){var e=document.activeElement.tagName.toLowerCase();if(null==new RegExp(e,["i"]).exec("input|textarea")&&N(o)){if(39===t.keyCode)return P(t),!1;if(37===t.keyCode)return E(t),!1}},X=function(){s.touch={start:{x:0,y:0},end:{x:0,y:0}},s.viewport.on("touchstart MSPointerDown pointerdown",Y),s.viewport.on("click",".w2rr_bxslider a",function(t){s.viewport.hasClass("click-disabled")&&(t.preventDefault(),s.viewport.removeClass("click-disabled"))})},Y=function(t){if("touchstart"===t.type||0===t.button)if(t.preventDefault(),s.controls.el.addClass("disabled"),s.working)s.controls.el.removeClass("disabled");else{s.touch.originalPos=o.position();var e=t.originalEvent,i=void 0!==e.changedTouches?e.changedTouches:[e],n="function"==typeof PointerEvent;if(n&&void 0===e.pointerId)return;s.touch.start.x=i[0].pageX,s.touch.start.y=i[0].pageY,s.viewport.get(0).setPointerCapture&&(s.pointerId=e.pointerId,s.viewport.get(0).setPointerCapture(s.pointerId)),s.originalClickTarget=e.originalTarget||e.target,s.originalClickButton=e.button,s.originalClickButtons=e.buttons,s.originalEventType=e.type,s.hasMove=!1,s.viewport.on("touchmove MSPointerMove pointermove",R),s.viewport.on("touchend MSPointerUp pointerup",Z),s.viewport.on("MSPointerCancel pointercancel",V)}},V=function(t){t.preventDefault(),S(s.touch.originalPos.left,"reset",0),s.controls.el.removeClass("disabled"),s.viewport.off("MSPointerCancel pointercancel",V),s.viewport.off("touchmove MSPointerMove pointermove",R),s.viewport.off("touchend MSPointerUp pointerup",Z),s.viewport.get(0).releasePointerCapture&&s.viewport.get(0).releasePointerCapture(s.pointerId)},R=function(t){var e=t.originalEvent,i=void 0!==e.changedTouches?e.changedTouches:[e],n=Math.abs(i[0].pageX-s.touch.start.x),o=Math.abs(i[0].pageY-s.touch.start.y),r=0,a=0;s.hasMove=!0,3*n>o&&s.settings.preventDefaultSwipeX?t.preventDefault():3*o>n&&s.settings.preventDefaultSwipeY&&t.preventDefault(),"touchmove"!==t.type&&t.preventDefault(),"fade"!==s.settings.mode&&s.settings.oneToOneTouch&&("horizontal"===s.settings.mode?(a=i[0].pageX-s.touch.start.x,r=s.touch.originalPos.left+a):(a=i[0].pageY-s.touch.start.y,r=s.touch.originalPos.top+a),S(r,"reset",0))},Z=function(e){e.preventDefault(),s.viewport.off("touchmove MSPointerMove pointermove",R),s.controls.el.removeClass("disabled");var i=e.originalEvent,n=void 0!==i.changedTouches?i.changedTouches:[i],r=0,a=0;s.touch.end.x=n[0].pageX,s.touch.end.y=n[0].pageY,"fade"===s.settings.mode?(a=Math.abs(s.touch.start.x-s.touch.end.x))>=s.settings.swipeThreshold&&(s.touch.start.x>s.touch.end.x?o.goToNextSlide():o.goToPrevSlide(),o.stopAuto()):("horizontal"===s.settings.mode?(a=s.touch.end.x-s.touch.start.x,r=s.touch.originalPos.left):(a=s.touch.end.y-s.touch.start.y,r=s.touch.originalPos.top),!s.settings.infiniteLoop&&(0===s.active.index&&a>0||s.active.last&&a<0)?S(r,"reset",200):Math.abs(a)>=s.settings.swipeThreshold?(a<0?o.goToNextSlide():o.goToPrevSlide(),o.stopAuto()):S(r,"reset",200)),s.viewport.off("touchend MSPointerUp pointerup",Z),s.viewport.get(0).releasePointerCapture&&s.viewport.get(0).releasePointerCapture(s.pointerId),!1!==s.hasMove||0!==s.originalClickButton&&"touchstart"!==s.originalEventType||t(s.originalClickTarget).trigger({type:"click",button:s.originalClickButton,buttons:s.originalClickButtons})},U=function(e){if(s.initialized)if(s.working)window.setTimeout(U,10);else{var i=t(window).width(),n=t(window).height();r===i&&a===n||(r=i,a=n,o.redrawSlider(),s.settings.onSliderResize.call(o,s.active.index))}},j=function(t){var e=v();s.settings.ariaHidden&&!s.settings.ticker&&(s.children.attr("aria-hidden","true"),s.children.slice(t,t+e).attr("aria-hidden","false"))},Q=function(t){return t<0?s.settings.infiniteLoop?f()-1:s.active.index:t>=f()?s.settings.infiniteLoop?0:s.active.index:t};return o.goToSlide=function(e,i){var n,r,a,l,d=!0,c=0,g={left:0,top:0},u=null;if(s.oldIndex=s.active.index,s.active.index=Q(e),!s.working&&s.active.index!==s.oldIndex){if(s.working=!0,void 0!==(d=s.settings.onSlideBefore.call(o,s.children.eq(s.active.index),s.oldIndex,s.active.index))&&!d)return s.active.index=s.oldIndex,void(s.working=!1);"next"===i?s.settings.onSlideNext.call(o,s.children.eq(s.active.index),s.oldIndex,s.active.index)||(d=!1):"prev"===i&&(s.settings.onSlidePrev.call(o,s.children.eq(s.active.index),s.oldIndex,s.active.index)||(d=!1)),s.active.last=s.active.index>=f()-1,(s.settings.pager||s.settings.pagerCustom)&&z(s.active.index),s.settings.controls&&q(),"fade"===s.settings.mode?(s.settings.adaptiveHeight&&s.viewport.height()!==p()&&s.viewport.animate({height:p()},s.settings.adaptiveHeightSpeed),s.children.filter(":visible").fadeOut(s.settings.speed).css({zIndex:0}),s.children.eq(s.active.index).css("zIndex",s.settings.slideZIndex+1).fadeIn(s.settings.speed,function(){t(this).css("zIndex",s.settings.slideZIndex),A()})):(s.settings.adaptiveHeight&&s.viewport.height()!==p()&&s.viewport.animate({height:p()},s.settings.adaptiveHeightSpeed),!s.settings.infiniteLoop&&s.carousel&&s.active.last?"horizontal"===s.settings.mode?(u=s.children.eq(s.children.length-1),g=u.position(),c=s.viewport.width()-u.outerWidth()):(n=s.children.length-s.settings.minSlides,g=s.children.eq(n).position()):s.carousel&&s.active.last&&"prev"===i?(r=1===s.settings.moveSlides?s.settings.maxSlides-x():(f()-1)*x()-(s.children.length-s.settings.maxSlides),u=o.children(".bx-clone").eq(r),g=u.position()):"next"===i&&0===s.active.index?(g=o.find("> .bx-clone").eq(s.settings.maxSlides).position(),s.active.last=!1):e>=0&&(l=e*parseInt(x()),g=s.children.eq(l).position()),void 0!==g&&(a="horizontal"===s.settings.mode?-(g.left-c):-g.top,S(a,"slide",s.settings.speed)),s.working=!1),s.settings.ariaHidden&&j(s.active.index*x())}},o.goToNextSlide=function(){if((s.settings.infiniteLoop||!s.active.last)&&!0!==s.working){var t=parseInt(s.active.index)+1;o.goToSlide(t,"next")}},o.goToPrevSlide=function(){if((s.settings.infiniteLoop||0!==s.active.index)&&!0!==s.working){var t=parseInt(s.active.index)-1;o.goToSlide(t,"prev")}},o.startAuto=function(t){s.interval||(s.interval=setInterval(function(){"next"===s.settings.autoDirection?o.goToNextSlide():o.goToPrevSlide()},s.settings.pause),s.settings.onAutoChange.call(o,!0),s.settings.autoControls&&!0!==t&&D("stop"))},o.stopAuto=function(t){s.autoPaused&&(s.autoPaused=!1),s.interval&&(clearInterval(s.interval),s.interval=null,s.settings.onAutoChange.call(o,!1),s.settings.autoControls&&!0!==t&&D("start"))},o.getCurrentSlide=function(){return s.active.index},o.getCurrentSlideElement=function(){return s.children.eq(s.active.index)},o.getSlideElement=function(t){return s.children.eq(t)},o.getSlideCount=function(){return s.children.length},o.isWorking=function(){return s.working},o.redrawSlider=function(){s.children.add(o.find(".bx-clone")).outerWidth(h()),s.viewport.css("height",p()),s.settings.ticker||m(),s.active.last&&(s.active.index=f()-1),s.active.index>=f()&&(s.active.last=!0),s.settings.pager&&!s.settings.pagerCustom&&(w(),z(s.active.index)),s.settings.ariaHidden&&j(s.active.index*x())},o.destroySlider=function(){s.initialized&&(s.initialized=!1,t(".bx-clone",this).remove(),s.children.each(function(){void 0!==t(this).data("origStyle")?t(this).attr("style",t(this).data("origStyle")):t(this).removeAttr("style")}),void 0!==t(this).data("origStyle")?this.attr("style",t(this).data("origStyle")):t(this).removeAttr("style"),t(this).unwrap().unwrap(),s.controls.el&&s.controls.el.remove(),s.controls.next&&s.controls.next.remove(),s.controls.prev&&s.controls.prev.remove(),s.pagerEl&&s.settings.controls&&!s.settings.pagerCustom&&s.pagerEl.remove(),t(".bx-caption",this).remove(),s.controls.autoEl&&s.controls.autoEl.remove(),clearInterval(s.interval),s.settings.responsive&&t(window).off("resize",U),s.settings.keyboardEnabled&&t(document).off("keydown",B),t(this).removeData("w2rr_bxslider"),t(window).off("blur",W).off("focus",H))},o.reloadSlider=function(e){void 0!==e&&(n=e),o.destroySlider(),l(),t(o).data("w2rr_bxslider",this)},l(),t(o).data("w2rr_bxslider",this),this}}}(jQuery);



/* ========================================================================
 * Bootstrap: tooltip.js v3.3.5
 * http://getbootstrap.com/javascript/#tooltip
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */
+function ($) {
  'use strict';

  // TOOLTIP PUBLIC CLASS DEFINITION
  // ===============================

  var Tooltip = function (element, options) {
    this.type       = null
    this.options    = null
    this.enabled    = null
    this.timeout    = null
    this.hoverState = null
    this.$element   = null
    this.inState    = null

    this.init('w2rr_tooltip', element, options)
  }

  Tooltip.VERSION  = '3.3.5'

  Tooltip.TRANSITION_DURATION = 150

  Tooltip.DEFAULTS = {
    animation: true,
    placement: 'top',
    selector: false,
    template: '<div class="w2rr-tooltip" role="tooltip"><div class="w2rr-tooltip-arrow"></div><div class="w2rr-tooltip-inner"></div></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    container: false,
    viewport: {
      selector: 'body',
      padding: 0
    }
  }

  Tooltip.prototype.init = function (type, element, options) {
    this.enabled   = true
    this.type      = type
    this.$element  = $(element)
    this.options   = this.getOptions(options)
    this.$viewport = this.options.viewport && $($.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : (this.options.viewport.selector || this.options.viewport))
    this.inState   = { click: false, hover: false, focus: false }

    if (this.$element[0] instanceof document.constructor && !this.options.selector) {
      throw new Error('`selector` option must be specified when initializing ' + this.type + ' on the window.document object!')
    }

    var triggers = this.options.trigger.split(' ')

    for (var i = triggers.length; i--;) {
      var trigger = triggers[i]

      if (trigger == 'click') {
        this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
      } else if (trigger != 'manual') {
        var eventIn  = trigger == 'hover' ? 'mouseenter' : 'focusin'
        var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout'

        this.$element.on(eventIn  + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
        this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
      }
    }

    this.options.selector ?
      (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
      this.fixTitle()
  }

  Tooltip.prototype.getDefaults = function () {
    return Tooltip.DEFAULTS
  }

  Tooltip.prototype.getOptions = function (options) {
    options = $.extend({}, this.getDefaults(), this.$element.data(), options)

    if (options.delay && typeof options.delay == 'number') {
      options.delay = {
        show: options.delay,
        hide: options.delay
      }
    }

    return options
  }

  Tooltip.prototype.getDelegateOptions = function () {
    var options  = {}
    var defaults = this.getDefaults()

    this._options && $.each(this._options, function (key, value) {
      if (defaults[key] != value) options[key] = value
    })

    return options
  }

  Tooltip.prototype.enter = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget).data('bs.' + this.type)

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
      $(obj.currentTarget).data('bs.' + this.type, self)
    }

    if (obj instanceof $.Event) {
      self.inState[obj.type == 'focusin' ? 'focus' : 'hover'] = true
    }

    if (self.tip().hasClass('w2rr-in') || self.hoverState == 'in') {
      self.hoverState = 'in'
      return
    }

    clearTimeout(self.timeout)

    self.hoverState = 'in'

    if (!self.options.delay || !self.options.delay.show) return self.show()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'in') self.show()
    }, self.options.delay.show)
  }

  Tooltip.prototype.isInStateTrue = function () {
    for (var key in this.inState) {
      if (this.inState[key]) return true
    }

    return false
  }

  Tooltip.prototype.leave = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget).data('bs.' + this.type)

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
      $(obj.currentTarget).data('bs.' + this.type, self)
    }

    if (obj instanceof $.Event) {
      self.inState[obj.type == 'focusout' ? 'focus' : 'hover'] = false
    }

    if (self.isInStateTrue()) return

    clearTimeout(self.timeout)

    self.hoverState = 'out'

    if (!self.options.delay || !self.options.delay.hide) return self.hide()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'out') self.hide()
    }, self.options.delay.hide)
  }

  Tooltip.prototype.show = function () {
    var e = $.Event('show.bs.' + this.type)

    if (this.hasContent() && this.enabled) {
      this.$element.trigger(e)

      var inDom = $.contains(this.$element[0].ownerDocument.documentElement, this.$element[0])
      if (e.isDefaultPrevented() || !inDom) return
      var that = this

      var $tip = this.tip()

      var tipId = this.getUID(this.type)

      this.setContent()
      $tip.attr('id', tipId)
      this.$element.attr('aria-describedby', tipId)

      if (this.options.animation) $tip.addClass('w2rr-fade')

      var placement = typeof this.options.placement == 'function' ?
        this.options.placement.call(this, $tip[0], this.$element[0]) :
        this.options.placement

      var autoToken = /\s?auto?\s?/i
      var autoPlace = autoToken.test(placement)
      if (autoPlace) placement = placement.replace(autoToken, '') || 'top'

      $tip
        .detach()
        .css({ top: 0, left: 0, display: 'block' })
        .addClass('w2rr-'+placement)
        .data('bs.' + this.type, this)

      this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)
      this.$element.trigger('inserted.bs.' + this.type)

      var pos          = this.getPosition()
      var actualWidth  = $tip[0].offsetWidth
      var actualHeight = $tip[0].offsetHeight

      if (autoPlace) {
        var orgPlacement = placement
        var viewportDim = this.getPosition(this.$viewport)

        placement = placement == 'bottom' && pos.bottom + actualHeight > viewportDim.bottom ? 'top'    :
                    placement == 'top'    && pos.top    - actualHeight < viewportDim.top    ? 'bottom' :
                    placement == 'right'  && pos.right  + actualWidth  > viewportDim.width  ? 'left'   :
                    placement == 'left'   && pos.left   - actualWidth  < viewportDim.left   ? 'right'  :
                    placement

        $tip
          .removeClass(orgPlacement)
          .addClass(placement)
      }

      var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight)

      this.applyPlacement(calculatedOffset, placement)

      var complete = function () {
        var prevHoverState = that.hoverState
        that.$element.trigger('shown.bs.' + that.type)
        that.hoverState = null

        if (prevHoverState == 'out') that.leave(that)
      }

      $.support.transition && this.$tip.hasClass('w2rr-fade') ?
        $tip
          .one('bsTransitionEnd', complete)
          .emulateTransitionEnd(Tooltip.TRANSITION_DURATION) :
        complete()
    }
  }

  Tooltip.prototype.applyPlacement = function (offset, placement) {
    var $tip   = this.tip()
    var width  = $tip[0].offsetWidth
    var height = $tip[0].offsetHeight

    // manually read margins because getBoundingClientRect includes difference
    var marginTop = parseInt($tip.css('margin-top'), 10)
    var marginLeft = parseInt($tip.css('margin-left'), 10)

    // we must check for NaN for ie 8/9
    if (isNaN(marginTop))  marginTop  = 0
    if (isNaN(marginLeft)) marginLeft = 0

    offset.top  += marginTop
    offset.left += marginLeft

    // $.fn.offset doesn't round pixel values
    // so we use setOffset directly with our own function B-0
    $.offset.setOffset($tip[0], $.extend({
      using: function (props) {
        $tip.css({
          top: Math.round(props.top),
          left: Math.round(props.left)
        })
      }
    }, offset), 0)

    $tip.addClass('w2rr-in')

    // check to see if placing tip in new offset caused the tip to resize itself
    var actualWidth  = $tip[0].offsetWidth
    var actualHeight = $tip[0].offsetHeight

    if (placement == 'top' && actualHeight != height) {
      offset.top = offset.top + height - actualHeight
    }

    var delta = this.getViewportAdjustedDelta(placement, offset, actualWidth, actualHeight)

    if (delta.left) offset.left += delta.left
    else offset.top += delta.top

    var isVertical          = /top|bottom/.test(placement)
    var arrowDelta          = isVertical ? delta.left * 2 - width + actualWidth : delta.top * 2 - height + actualHeight
    var arrowOffsetPosition = isVertical ? 'offsetWidth' : 'offsetHeight'

    $tip.offset(offset)
    this.replaceArrow(arrowDelta, $tip[0][arrowOffsetPosition], isVertical)
  }

  Tooltip.prototype.replaceArrow = function (delta, dimension, isVertical) {
    this.arrow()
      .css(isVertical ? 'left' : 'top', 50 * (1 - delta / dimension) + '%')
      .css(isVertical ? 'top' : 'left', '')
  }

  Tooltip.prototype.setContent = function () {
    var $tip  = this.tip()
    var title = this.getTitle()

    $tip.find('.w2rr-tooltip-inner')[this.options.html ? 'html' : 'text'](title)
    $tip.removeClass('w2rr-fade w2rr-in w2rr-top w2rr-bottom w2rr-left w2rr-right')
  }

  Tooltip.prototype.hide = function (callback) {
    var that = this
    var $tip = $(this.$tip)
    var e    = $.Event('hide.bs.' + this.type)

    function complete() {
      if (that.hoverState != 'in') $tip.detach()
      that.$element
        .removeAttr('aria-describedby')
        .trigger('hidden.bs.' + that.type)
      callback && callback()
    }

    this.$element.trigger(e)

    if (e.isDefaultPrevented()) return

    $tip.removeClass('w2rr-in')

    $.support.transition && $tip.hasClass('w2rr-fade') ?
      $tip
        .one('bsTransitionEnd', complete)
        .emulateTransitionEnd(Tooltip.TRANSITION_DURATION) :
      complete()

    this.hoverState = null

    return this
  }

  Tooltip.prototype.fixTitle = function () {
    var $e = this.$element
    if ($e.attr('title') || typeof $e.attr('data-original-title') != 'string') {
      $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
    }
  }

  Tooltip.prototype.hasContent = function () {
    return this.getTitle()
  }

  Tooltip.prototype.getPosition = function ($element) {
    $element   = $element || this.$element

    var el     = $element[0]
    var isBody = el.tagName == 'BODY'

    var elRect    = el.getBoundingClientRect()
    if (elRect.width == null) {
      // width and height are missing in IE8, so compute them manually; see https://github.com/twbs/bootstrap/issues/14093
      elRect = $.extend({}, elRect, { width: elRect.right - elRect.left, height: elRect.bottom - elRect.top })
    }
    var elOffset  = isBody ? { top: 0, left: 0 } : $element.offset()
    var scroll    = { scroll: isBody ? document.documentElement.scrollTop || document.body.scrollTop : $element.scrollTop() }
    var outerDims = isBody ? { width: $(window).width(), height: $(window).height() } : null

    return $.extend({}, elRect, scroll, outerDims, elOffset)
  }

  Tooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
    return placement == 'bottom' ? { top: pos.top + pos.height,   left: pos.left + pos.width / 2 - actualWidth / 2 } :
           placement == 'top'    ? { top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2 } :
           placement == 'left'   ? { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth } :
        /* placement == 'right' */ { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width }

  }

  Tooltip.prototype.getViewportAdjustedDelta = function (placement, pos, actualWidth, actualHeight) {
    var delta = { top: 0, left: 0 }
    if (!this.$viewport) return delta

    var viewportPadding = this.options.viewport && this.options.viewport.padding || 0
    var viewportDimensions = this.getPosition(this.$viewport)

    if (/right|left/.test(placement)) {
      var topEdgeOffset    = pos.top - viewportPadding - viewportDimensions.scroll
      var bottomEdgeOffset = pos.top + viewportPadding - viewportDimensions.scroll + actualHeight
      if (topEdgeOffset < viewportDimensions.top) { // top overflow
        delta.top = viewportDimensions.top - topEdgeOffset
      } else if (bottomEdgeOffset > viewportDimensions.top + viewportDimensions.height) { // bottom overflow
        delta.top = viewportDimensions.top + viewportDimensions.height - bottomEdgeOffset
      }
    } else {
      var leftEdgeOffset  = pos.left - viewportPadding
      var rightEdgeOffset = pos.left + viewportPadding + actualWidth
      if (leftEdgeOffset < viewportDimensions.left) { // left overflow
        delta.left = viewportDimensions.left - leftEdgeOffset
      } else if (rightEdgeOffset > viewportDimensions.right) { // right overflow
        delta.left = viewportDimensions.left + viewportDimensions.width - rightEdgeOffset
      }
    }

    return delta
  }

  Tooltip.prototype.getTitle = function () {
    var title
    var $e = this.$element
    var o  = this.options

    title = $e.attr('data-original-title')
      || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

    return title
  }

  Tooltip.prototype.getUID = function (prefix) {
    do prefix += ~~(Math.random() * 1000000)
    while (document.getElementById(prefix))
    return prefix
  }

  Tooltip.prototype.tip = function () {
    if (!this.$tip) {
      this.$tip = $(this.options.template)
      if (this.$tip.length != 1) {
        throw new Error(this.type + ' `template` option must consist of exactly 1 top-level element!')
      }
    }
    return this.$tip
  }

  Tooltip.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.w2rr-tooltip-arrow'))
  }

  Tooltip.prototype.enable = function () {
    this.enabled = true
  }

  Tooltip.prototype.disable = function () {
    this.enabled = false
  }

  Tooltip.prototype.toggleEnabled = function () {
    this.enabled = !this.enabled
  }

  Tooltip.prototype.toggle = function (e) {
    var self = this
    if (e) {
      self = $(e.currentTarget).data('bs.' + this.type)
      if (!self) {
        self = new this.constructor(e.currentTarget, this.getDelegateOptions())
        $(e.currentTarget).data('bs.' + this.type, self)
      }
    }

    if (e) {
      self.inState.click = !self.inState.click
      if (self.isInStateTrue()) self.enter(self)
      else self.leave(self)
    } else {
      self.tip().hasClass('w2rr-in') ? self.leave(self) : self.enter(self)
    }
  }

  Tooltip.prototype.destroy = function () {
    var that = this
    clearTimeout(this.timeout)
    this.hide(function () {
      that.$element.off('.' + that.type).removeData('bs.' + that.type)
      if (that.$tip) {
        that.$tip.detach()
      }
      that.$tip = null
      that.$arrow = null
      that.$viewport = null
    })
  }


  // TOOLTIP PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.w2rr_tooltip')
      var options = typeof option == 'object' && option

      if (!data && /destroy|hide/.test(option)) return
      if (!data) $this.data('bs.w2rr_tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.w2rr_tooltip

  $.fn.w2rr_tooltip             = Plugin
  $.fn.w2rr_tooltip.Constructor = Tooltip


  // TOOLTIP NO CONFLICT
  // ===================

  $.fn.w2rr_tooltip.noConflict = function () {
    $.fn.w2rr_tooltip = old
    return this
  }

}(jQuery);

/* ========================================================================
 * Bootstrap: popover.js v3.3.5
 * http://getbootstrap.com/javascript/#popovers
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */
+function ($) {
  'use strict';

  // POPOVER PUBLIC CLASS DEFINITION
  // ===============================

  var Popover = function (element, options) {
    this.init('w2rr_popover', element, options)
  }

  if (!$.fn.w2rr_tooltip) throw new Error('Popover requires tooltip.js')

  Popover.VERSION  = '3.3.5'

  Popover.DEFAULTS = $.extend({}, $.fn.w2rr_tooltip.Constructor.DEFAULTS, {
    placement: 'right',
    trigger: 'click',
    content: '',
    template: '<div class="w2rr-popover" role="tooltip"><div class="w2rr-arrow"></div><h3 class="w2rr-popover-title"></h3><div class="w2rr-popover-content"></div></div>'
  })


  // NOTE: POPOVER EXTENDS tooltip.js
  // ================================

  Popover.prototype = $.extend({}, $.fn.w2rr_tooltip.Constructor.prototype)

  Popover.prototype.constructor = Popover

  Popover.prototype.getDefaults = function () {
    return Popover.DEFAULTS
  }

  Popover.prototype.setContent = function () {
    var $tip    = this.tip()
    var title   = this.getTitle()
    var content = this.getContent()

    $tip.find('.w2rr-popover-title')[this.options.html ? 'html' : 'text'](title)
    $tip.find('.w2rr-popover-content').children().detach().end()[ // we use append for html objects to maintain js events
      this.options.html ? (typeof content == 'string' ? 'html' : 'append') : 'text'
    ](content)

    $tip.removeClass('w2rr-fade w2rr-top w2rr-bottom w2rr-left w2rr-right w2rr-in')

    // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
    // this manually by checking the contents.
    if (!$tip.find('.w2rr-popover-title').html()) $tip.find('.w2rr-popover-title').hide()
  }

  Popover.prototype.hasContent = function () {
    return this.getTitle() || this.getContent()
  }

  Popover.prototype.getContent = function () {
    var $e = this.$element
    var o  = this.options

    return $e.attr('data-content')
      || (typeof o.content == 'function' ?
            o.content.call($e[0]) :
            o.content)
  }

  Popover.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.arrow'))
  }
  // POPOVER PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.w2rr_popover')
      var options = typeof option == 'object' && option

      if (!data && /destroy|hide/.test(option)) return
      if (!data) $this.data('bs.w2rr_popover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.w2rr_popover

  $.fn.w2rr_popover             = Plugin
  $.fn.w2rr_popover.Constructor = Popover


  // POPOVER NO CONFLICT
  // ===================

  $.fn.w2rr_popover.noConflict = function () {
    $.fn.popover = old
    return this
  }

}(jQuery);