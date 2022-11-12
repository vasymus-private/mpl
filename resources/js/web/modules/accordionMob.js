var accordionMob = (function ($) {
    "use strict"

    function init() {
        let allAccordions = $(".accordion .data")
        let allAccordionItems = $(".accordion .accordion-item")
        let $mbBodyLeft = $(".mb-body-left")
        let $menuMain = $(".menu_main")

        allAccordionItems.on("click", function (e) {
            let $this = $(this)

            if ($this.hasClass("open")) {
                $this.removeClass("open")
                $this.next().slideUp("slow", function () {
                    $mbBodyLeft.animate({ scrollTop: 0 }, 500)
                })
            } else {
                allAccordions.slideUp("slow")
                allAccordionItems.removeClass("open")
                $this.addClass("open")
                $this.next().slideDown("slow", function () {
                    $mbBodyLeft.slimScroll({
                        height: $menuMain.height(),
                        touchScrollStep: 100,
                    })

                    let pTop = $this.parents(".fltr").position().top
                    let eTop = $this.offset().top

                    let top

                    if (eTop < 0) top = Math.abs(pTop) - Math.abs(eTop)
                    else top = eTop + Math.abs(pTop)

                    console.log(top)

                    $mbBodyLeft.animate({ scrollTop: top }, 500)
                })
            }

            return false
        })
    }

    return {
        init: init,
    }
})(jQuery)

export default accordionMob
