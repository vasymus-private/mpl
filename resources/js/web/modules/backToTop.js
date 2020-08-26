var backToTop = (function ($) {
    'use strict';

    function init() {
        var offset = 220;
        var duration = 500;

        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('.back-to-top').fadeIn(duration);
            } else {
                jQuery('.back-to-top').fadeOut(duration);
            }
        });

        jQuery('.back-to-top').click(function (event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
    }

    return {
        init: init
    };

}(jQuery));

export default backToTop;
