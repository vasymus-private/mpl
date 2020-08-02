import Slideout from 'slideout'


var filterMobile = (function ($) {
    'use strict';

    function init() {
        let $main = $('.js-sidebar-slide-main-2')
        let $menu = $('.js-sidebar-slide-menu-2')

        if (!$main.length || !$menu.length) return

        let slideout = new Slideout({
            'panel': document.querySelector('.js-sidebar-slide-main-2'),
            'menu': document.querySelector('.js-sidebar-slide-menu-2'),
            'padding': 276,
            'tolerance': 70,
            'touch': false
        });

        let $toggler = $('.js-sidebar-slide-toggle-2')
        let $body = $('body')

        $toggler.on("click", event => {
            event.preventDefault()
            if (slideout.isOpen()) {
                slideout.close()
                $body.removeClass('opened-filter')
            } else {
                slideout.open()
                $body.addClass('opened-filter')
            }
        });

        // https://stackoverflow.com/a/7385673/12540255
        // https://stackoverflow.com/a/25135822/12540255
        $('body').on('mouseup touchend', event => {
            if (!slideout.isOpen()) return true;

            if (!$menu.is(event.target) && $menu.has(event.target).length === 0) {
                slideout.close()
                $body.removeClass('opened-filter')
            }
        })

    }

    return {
        init: init
    };

}(jQuery));

export default filterMobile;
