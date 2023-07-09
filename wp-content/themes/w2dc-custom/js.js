jQuery(document).ready(function($) {
	
	var toppadding = 0;
	function calc_sticky_toppadding() {
		toppadding = 0;
		if (toppadding == 0 && $('body').hasClass('admin-bar')) {
			toppadding = 32;
		}
		if ($('.site-header.header-fixed.fixed:visible').length) {
			if ($('.site-header.header-fixed.fixed:visible').css("position") == 'fixed') {
				var headerHeight = $('.site-header.header-fixed.fixed').outerHeight();
				toppadding = toppadding + headerHeight;
			}
		}
		$('.w2dc-theme-sticky').height($(window).height()-toppadding).css('top', toppadding);
	}
	
	var currentPoint = function() {
		if (follow_current_point_flag) {
			var current_item_id = false;
			$('.w2dc-docs h2[id], .w2dc-docs h3[id], .w2dc-docs h4[id]').each(function() {
				if ($('.w2dc-theme-sticky a[href=\\#'+$(this).attr('id')+']').length) {
					if ($(this).offset().top > $(window).scrollTop() && $(this).offset().top < $(window).scrollTop() + ($(window).height()/4)*3) {
						current_item_id = $(this).attr('id');
					} else if ($(this).offset().top < $(window).scrollTop()) {
						current_item_id = $(this).attr('id');
					}
				}
			});
			if (current_item_id) {
				// '#' is a special char and needs to be escaped like 'a[href*=\\#]:not([href=\\#])'
				$('.w2dc-theme-sticky').find('a[href*=\\#]:not([href=\\#]) strong').contents().unwrap();
				$('.w2dc-theme-sticky').find('a[href=\\#'+current_item_id+']').wrapInner('<strong></strong>');
			}
		}
	}
	
	var follow_current_point_flag = true;
	$(window).scroll(function() {
		currentPoint();
	});
	
	var $window = $(window);
	var width = $window.width();
	var height = $window.height();

	setInterval(function () {
		if ((width != $window.width()) || (height != $window.height())) {
			width = $window.width();
			height = $window.height();

			calc_sticky_toppadding();
			currentPoint();
		}
	}, 300);
	
	// '#' is a special char and needs to be escaped like 'a[href*=\\#]:not([href=\\#])'
	$('body').on('click', 'a[href*=\\#]:not([href=\\#])', function() {
		follow_current_point_flag = false;
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top - toppadding
				}, 1000, function() {
					follow_current_point_flag = true;
					currentPoint();
				});
				history.pushState(null, null, '#' + $(this.hash).attr('id'));
				return false;
			}
		}
	});
	
	$('.w2dc-docs h2[id], .w2dc-docs h3[id], .w2dc-docs h4[id]').each(function() {
		$(this).html($(this).html()+' <a class=\"fa fa-link w2dc-docs-link\" title=\"Link\" href=\"#'+$(this).attr('id')+'\"></a>');
	});
		
	$('.w2dc-docs a')
	.filter(function() {
		return this.hostname && this.hostname !== location.hostname;
	})
	.append('&nbsp;<i class=\"fa fa-external-link-alt\"></i>')
	.attr('target', '_blank');
	
	var window_location_link = window.location.protocol + '//' + window.location.host + window.location.pathname;
	
	$('.w2dc-table-of-contents a[href="'+ window_location_link +'"]').addClass('w2dc-table-of-contents-active-link');
	
	//$(window).load(function() {
		calc_sticky_toppadding();
	//});
	

	var current_link = $('.w2dc-table-of-contents a[href="'+ window_location_link +'"]');
	if (current_link.length) {
		var next_link,
			prev_link,
			next_link_span = '',
			prev_link_span = '';
		var links_array = $('.w2dc-table-of-contents li a');
		links_array.each(function(i) {
			if ($(this).hasClass('w2dc-table-of-contents-active-link')) {
				prev_link = links_array[i-1];
				if (prev_link && typeof prev_link != undefined) {
					prev_link_span = '<span class="w2dc-demo-prev-docs-links">&lt; '+$(prev_link)[0].outerHTML+'</span>';
				}
				next_link = links_array[i+1];
				if (next_link && typeof next_link != undefined) {
					next_link_span = '<span class="w2dc-demo-next-docs-links">'+$(next_link)[0].outerHTML+' &gt;</span>';
				}
			}
		});
		if (next_link_span || prev_link_span) {
			$('.w2dc-docs-side').prepend('<div class="w2dc-demo-prev-next-docs-links">'+prev_link_span+next_link_span+'</div>')
		}
	}
	
});
