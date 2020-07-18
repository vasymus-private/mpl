import Slideout from 'slideout'


var navMenu = (function ($) {
    'use strict';

    function init() {
        var slideout = new Slideout({
            'panel': document.querySelector('.gtk_main'),
            'menu': document.querySelector('.gtk_menu'),
            'padding': 276,
            'tolerance': 70,
            'touch': false
        });

        var menu_a = jQuery('.gtk_menu a.toggle');
        var main_a = jQuery('.gtk_main a.toggle');
        var wrapper = jQuery('.wrapper');

        main_a.click(function (e) {
            e.preventDefault();
            //menu_a.toggleClass('opened');
            slideout.toggle();
        });

        menu_a.click(function () {
            slideout.close();
        });

    }

    return {
        init: init
    };

}(jQuery));

export default navMenu;
