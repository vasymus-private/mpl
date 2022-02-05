import StickySidebar from "sticky-sidebar"
;(function ($) {
    $().ready(() => {
        if ($(".js-sticky-sidebar").length) {
            new StickySidebar(".js-sticky-sidebar", {
                topSpacing: 30,
                bottomSpacing: 20,
                innerWrapperSelector: ".js-inner-wrapper-sticky",
            })
        }
    })
})(jQuery)
