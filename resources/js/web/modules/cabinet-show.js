var cabinetShow = (function ($) {
    "use strict"

    function init() {
        var ifClick = false
        const link = $(".sale-order-detail__read-more")
        const content = $(".sale-order-detail__content")
        link.on("click", () => {
            if (ifClick) {
                link.removeClass("active")
                link.html("подробнее")
                content.hide()
                ifClick = false
            } else {
                link.addClass("active")
                link.html("свернуть")
                content.show()
                ifClick = true
            }
        })
    }

    return {
        init: init,
    }
})(jQuery)

export default cabinetShow
