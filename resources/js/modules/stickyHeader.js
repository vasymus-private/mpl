var stickyHeader = (function ($) {
    'use strict';

    function init() {
        $(window).scroll(function () {
            var sticky = $('.header-sticky'),
                scroll = $(window).scrollTop();

            if (scroll >= 100) sticky.addClass('fixed');
            else sticky.removeClass('fixed');
        });
    }

    return {
        init: init
    };

}(jQuery));

export default stickyHeader;
