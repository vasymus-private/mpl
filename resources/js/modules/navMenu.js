import Slideout from 'slideout'


var navMenu = (function ($) {
    'use strict';

    function init() {
        let $gtkMain = $('.gtk_main')
        let $gtkMenu = $('.gtk_menu')

        if (!$gtkMain.length || !$gtkMenu.length) return

        let slideout = new Slideout({
            'panel': document.querySelector('.gtk_main'),
            'menu': document.querySelector('.gtk_menu'),
            'padding': 276,
            'tolerance': 70,
            'touch': false
        });

        let menu_a = jQuery('.gtk_menu a.toggle');
        let main_a = jQuery('.gtk_main a.toggle');
        let wrapper = jQuery('.wrapper');

        main_a.click(function (e) {
            e.preventDefault();
            //menu_a.toggleClass('opened');
            slideout.toggle();
        });

        menu_a.click(function () {
            slideout.close();
        });

        // https://stackoverflow.com/a/7385673/12540255
        // https://stackoverflow.com/a/25135822/12540255
        $('body').on('mouseup touchend', event => {
            if (!slideout.isOpen()) return true;

            if (!$gtkMenu.is(event.target) && $gtkMenu.has(event.target).length === 0) {
                slideout.close()
            }
        })
    }

    return {
        init: init
    };

}(jQuery));

export default navMenu;
