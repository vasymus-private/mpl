import Slideout from 'slideout'


var filterMobile = (function ($) {
    'use strict';

    function init() {
        var slideout = new Slideout({
            'panel': document.querySelector('.gtk_panel'),
            'menu': document.querySelector('.gtk_filter'),
            'padding': 276,
            'tolerance': 70,
            'touch': false
        });

        var filterButton = jQuery('.gtk_filter .filter-mobile__close');
        var mainButton = jQuery('.gtk_main .btn-sort');
        var classBodyForOpen = jQuery('body')

        mainButton.click(function (e) {
            e.preventDefault();
            classBodyForOpen.toggleClass('opened-filter');
            slideout.toggle();
        });

        filterButton.click(function () {
            slideout.close();
            classBodyForOpen.removeClass('opened-filter')
        });

    }

    return {
        init: init
    };

}(jQuery));

export default filterMobile;
