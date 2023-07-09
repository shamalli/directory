jQuery(document).ready(function($) {
    'use strict';

    var container = $('.blog .posts');
    container.imagesLoaded(function() {
        container.masonry({
            itemSelector: '.type-post',
            percentPosition: true,
            gutter: 30
        });
    });

    /**
     * Hero animate
     */
    $('.hero').addClass('hero-animate');

    /**
     * Page navigation scroll
     */
    $('.page-navigation a').on('click', function(e) {
        e.preventDefault();

        var id = $(this).attr('href');

        $.scrollTo(id, 1200, {
            axis: 'y',
            offset: -80
        });
    });

    /**
     * Site navigation
     */
    $('.site-navigation-toggle').on('click', function(e) {
        $('.site-navigation').toggleClass('open');
    });

    /**
     * Scroll
     */
    $(window).scroll(function() {
        if ($(this).scrollTop() > 220){
            $('.header-sticky').addClass('active');
        }
        else{
            $('.header-sticky').removeClass('active');
        }
    });
});