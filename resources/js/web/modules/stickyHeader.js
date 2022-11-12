let stickyHeader = (function ($) {
    "use strict"

    function init() {
        $(window).scroll(function () {
            let sticky = $(".header-sticky")
            let scroll = $(window).scrollTop()

            if (scroll >= 100) {
                sticky.addClass("fixed")
            } else {
                sticky.removeClass("fixed")
            }
        })
    }

    return {
        init: init,
    }
})(jQuery)

export default stickyHeader
