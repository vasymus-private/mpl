var slimScroll = (function ($) {
    "use strict"

    function init() {
        $(".mb-body-left").slimScroll({
            height: $(".menu_main").height(),
            touchScrollStep: 100,
        })
    }

    return {
        init: init,
    }
})(jQuery)

export default slimScroll
