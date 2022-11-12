import Slideout from "slideout"

var navMenu = (function ($) {
    "use strict"

    function init() {
        let $main = $(".js-sidebar-slide-main-1")
        let $menu = $(".js-sidebar-slide-menu-1")

        if (!$main.length || !$menu.length) return

        let slideout = new Slideout({
            panel: document.querySelector(".js-sidebar-slide-main-1"),
            menu: document.querySelector(".js-sidebar-slide-menu-1"),
            padding: 300,
            tolerance: 70,
            touch: false,
        })

        let $toggler1 = jQuery(".js-sidebar-slide-menu-1 a.toggle")
        let $toggler2 = jQuery(".js-sidebar-slide-main-1 a.toggle")

        $toggler2.click(function (e) {
            e.preventDefault()
            slideout.toggle()
        })

        $toggler1.click(function () {
            slideout.close()
        })

        // https://stackoverflow.com/a/7385673/12540255
        // https://stackoverflow.com/a/25135822/12540255
        $("body").on("mouseup touchend", (event) => {
            if (!slideout.isOpen()) return true

            if (
                !$menu.is(event.target) &&
                $menu.has(event.target).length === 0
            ) {
                slideout.close()
            }
        })
    }

    return {
        init: init,
    }
})(jQuery)

export default navMenu
