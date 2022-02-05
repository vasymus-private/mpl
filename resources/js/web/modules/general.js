import { getProductsHoverOnPopover } from "../helpers/products"
import { guidGenerator, hideOnClickOutside } from "../../helpers/common"

;(function ($) {
    $().ready(() => {
        //jQuery('.js-form-select-autosubmit').on('')

        $('[data-toggle="tooltip"]').tooltip()

        const MANUAL_TOOLTIP_TIMEOUT_DEFAULT = 6000
        let $manualTooltips = $(".js-manual-tooltip")
        $manualTooltips.each((i, el) => {
            let $el = $(el)

            if (!$el.data("title")) return true

            let tooltipClass = $el.data("class")

            $el.tooltip({
                placement: $el.data("placement"),
                trigger: "manual",
                template: `
                    <div class="tooltip ${tooltipClass}" role="tooltip">
                        <div class="arrow"></div>
                        <a class="js-tooltip-close tooltip-close" href="javascript:void(0)" type="button">X</a>
                        <div class="tooltip-inner"></div>
                    </div>
                `,
            })

            let timeout
            let time = $el.data("timeout") || MANUAL_TOOLTIP_TIMEOUT_DEFAULT
            let hideCB = () => {
                $el.tooltip("hide")
                clearTimeout(timeout)
                timeout = null
            }

            $el.on("click", (event) => {
                event.preventDefault()
                if (timeout) return true

                $el.tooltip("show")
                timeout = setTimeout(hideCB, time)
            })

            $el.on("shown.bs.tooltip", (event) => {
                let tooltipId = $(event.target).attr("aria-describedby")

                let tooltipSelector = `#${tooltipId}`
                let $tooltip = $(tooltipSelector)

                $tooltip.find(".js-tooltip-close").on("click", hideCB)
                hideOnClickOutside(tooltipSelector, hideCB)
            })
        })

        $(".js-back").on("click", (event) => {
            event.preventDefault()
            window.history.go(-1)
        })

        let $productItems = getProductsHoverOnPopover()

        $productItems.each((ind, el) => {
            let $productItem = $(el)
            if (!$productItem.is(":visible")) {
                return
            }
            $productItem.popover({
                container: "body",
                html: true,
                //placement : "right",
                template:
                    '<div class="popover popover-product-item" role="tooltip"><div class="arrow"></div><button type="button" class="popover-close js-product-item-popover-close" style="position: absolute; top: 0; right: 0">X</button><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                trigger: "manual",
                sanitize: false,
                title: "&nbsp;",
            })

            $productItem.on("shown.bs.popover", (event) => {
                let $target = $(event.target)
                let $popup = $(`#${$target.attr("aria-describedby")}`)
                $popup
                    .find(".js-product-item-popover-close")
                    .on("click", (ev) => {
                        $productItem.popover("hide")
                    })
            })

            $productItem.popover("show")
        })

        let $inputsHideOnFocus = $(".js-input-hide-on-focus")
        $inputsHideOnFocus.each((ind, el) => {
            let $input = $(el)

            let value = ""

            $input.on("focus", (event) => {
                value = $input.val()
                $input.val("")
            })
            $input.on("blur", (event) => {
                if (!$input.val()) $input.val(value)
            })
        })

        let $saveInput = $(".js-save-input")
        let $clearAllSavedInputs = $(".js-clear-all-saved-inputs")
        // init
        $saveInput.each(function (i, el) {
            let $el = $(el)
            let id = $el.data("id") || $el.attr("id") || $el.attr("name")
            if (!id) {
                return true
            }
            let currentSaveInput = localStorage.getItem("save-input")
            try {
                currentSaveInput = JSON.parse(currentSaveInput) || {}
            } catch (ignored) {
                currentSaveInput = {}
            }
            let value = currentSaveInput[id]
            if (!value) {
                return true
            }
            $el.val(value)
        })
        // add listeners
        $saveInput.on("blur", function (event) {
            let $el = $(event.target)
            let id = $el.data("id") || $el.attr("id") || $el.attr("name")
            if (!id) {
                return true
            }
            let currentSaveInput = localStorage.getItem("save-input")
            try {
                currentSaveInput = JSON.parse(currentSaveInput) || {}
            } catch (ignored) {
                currentSaveInput = {}
            }
            currentSaveInput[id] = $el.val()
            localStorage.setItem("save-input", JSON.stringify(currentSaveInput))
        })
        $clearAllSavedInputs.on("click", function () {
            localStorage.setItem("save-input", JSON.stringify({}))
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
