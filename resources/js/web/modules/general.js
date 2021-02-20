import {getProductsHoverOnPopover} from '../helpers/products'

(function($) {
    $().ready(() => {
        //jQuery('.js-form-select-autosubmit').on('')

        $('[data-toggle="tooltip"]').tooltip()

        const MANUAL_TOOLTIP_TIMEOUT_DEFAULT = 6000
        let $manualTooltips = $(".js-manual-tooltip")
        $manualTooltips.each((i, el) => {
            let $el = $(el)

            if (!$el.data("title")) return true

            $el.tooltip({
                placement : $el.data("placement"),
                trigger : "manual",
                template : '<div class="tooltip tooltip-variants" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            })

            let timeout
            $el.on("click", (event) => {
                event.preventDefault()
                if (timeout) return true

                $el.tooltip("show")
                timeout = setTimeout(() => {
                    $el.tooltip("hide")
                    timeout = null
                }, $el.data("timeout") || MANUAL_TOOLTIP_TIMEOUT_DEFAULT)
            })

        })

        $('.js-back').on('click', event => {
            event.preventDefault()
            window.history.go(-1)
        })

        let $productItems = getProductsHoverOnPopover()

        $productItems.each((ind, el) => {
            let $productItem = $(el)
            $productItem.popover({
                container : "body",
                html : true,
                //placement : "right",
                template : '<div class="popover popover-product-item" role="tooltip"><div class="arrow"></div><button type="button" class="popover-close js-product-item-popover-close" style="position: absolute; top: 0; right: 0">X</button><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                trigger : "manual",
                sanitize : false,
                title : "&nbsp;",
            })

            $productItem.on("shown.bs.popover", event => {
                let $target = $(event.target)
                let $popup = $(`#${$target.attr('aria-describedby')}`)
                $popup.find(".js-product-item-popover-close").on("click", ev => {
                    $productItem.popover("hide")
                })
            })

            $productItem.popover("show")
        })

        let $inputsHideOnFocus = $(".js-input-hide-on-focus")
        $inputsHideOnFocus.each((ind, el) => {
            let $input = $(el)

            let value = ""

            $input.on("focus", event => {
                value = $input.val()
                $input.val("")
            })
            $input.on("blur", event => {
                if (!$input.val()) $input.val(value)
            })
        })

        /*let $inputKeyupValidate = $('.js-keyup-validate')
        $inputKeyupValidate.each((ind, el) => {
            let $input = $(el)

            let min = $input.attr('min')

            $input.on('keyup keydown', (event) => {
                debugger
                if (
                    $(event.currentTarget).val() < min &&
                    event.keyCode !== 46 && // delete button
                    event.keyCode !== 8 // delete button
                ) {
                    event.preventDefault()
                }
            })
        })*/
    })
})(jQuery)
