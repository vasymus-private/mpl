import {getProductsHoverOnPopover} from '../helpers/products'

(function($) {
    $().ready(() => {
        //jQuery('.js-form-select-autosubmit').on('')

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
                template : '<div class="popover" role="tooltip"><div class="arrow"></div><button type="button" class="popover-close js-product-item-popover-close" style="position: absolute; top: 0; right: 0">X</button><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
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
    })
})(jQuery)
