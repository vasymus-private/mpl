var sidebarMenu = (function ($) {
    'use strict';

    function init() {
        $('.dropdown-vertical > li > a').click(function () {
            $('.dropdown-vertical > li').removeClass('active');
            $(this).parent().addClass("active");
            $('.dropdown-vertical > li > ul').hide();
            $(this).next().toggle();
            return false;
        })

        $('body').click(function () {
            $('.dropdown-vertical > li').removeClass('active');
            $('.dropdown-vertical > li > ul').hide();
        });
    }

    return {
        init: init
    };

}(jQuery));

export default sidebarMenu;
