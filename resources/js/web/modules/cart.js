import {
    getAddToCartInputCountClass,
    getCartItemSumFormatted$,
    getCartRow$,
    getCartDeletes$,
    getCartColumnCountPartNormal$,
    getCartColumnCountPartDeleted$,
    getCartDelete$,
    getAddToCartPopoverClass,
    getAddToCartPopover$,
} from "../helpers/products"
import Rest from "../../helpers/Rest"
import ajaxUrls from "../settings/ajaxUrls"
import Mustache from "mustache"
import { numberWithSpaces } from "../../helpers/common"
import { debounce } from "lodash"
import Products from "../Products"
;(function ($) {
    $().ready(() => {
        let animationClass = "pulsing"

        let $addToCarts = $(".js-add-to-cart")
        let $addToCartCounts = $(".js-add-to-cart-count")
        let $addToCartCountsAnimate = $(".js-add-to-cart-animate")
        let $addToCartCountsTooltip = $(".js-add-to-cart-tooltip")

        let $sidebarMenuCart = $(".js-sidebar-menu-cart")
        let $sidebarMenuCartList = $(".js-sidebar-menu-cart-list")
        let $_sidebarMenuTemplate = $("#sidebar-menu-cart-item")
        let sidebarMenuTemplate = $_sidebarMenuTemplate.html()

        let $inputHighlighted = $(".js-add-to-cart-input-instant-highlighted")
        let inputHighlightedClass = "input-highlighted"

        let $totalSumFormatted = $(".js-cart-total-sum-formatted")

        let $cartDecrement = $(".js-cart-decrement")
        let $cartIncrement = $(".js-cart-increment")
        let $addToCartInstantInput = $(".js-add-to-cart-instant-input")

        let $cartDeletes = getCartDeletes$()

        let $cartRestores = $(".js-cart-restore")
        let $cartDestroys = $(".js-cart-destroy")

        const TIMEOUT_MS = 4000
        const TIMEOUT_POPOVER_MS = 4000

        const IS_IN_CART_CLASS = "is-in-cart"

        handleSidebarCartMenu()

        handleCartPage()

        function handleCartPage() {
            $cartDecrement.on(
                "click",
                debounce((event) => {
                    event.preventDefault()
                    let $target = $(event.currentTarget)
                    let id = $target.data("id")
                    let $input = $(`.${getAddToCartInputCountClass(id)}`)
                    let currentCount = Math.abs($input.val()) || 1
                    if (currentCount === 1) return true
                    let count = currentCount - 1

                    handleAjaxChangeCountOnCartPage(id, count, $input)
                }, 500)
            )

            $cartIncrement.on(
                "click",
                debounce((event) => {
                    event.preventDefault()
                    let $target = $(event.currentTarget)
                    let id = $target.data("id")
                    let $input = $(`.${getAddToCartInputCountClass(id)}`)
                    let currentCount = Math.abs($input.val()) || 1
                    let count = currentCount + 1

                    handleAjaxChangeCountOnCartPage(id, count, $input)
                }, 500)
            )

            $addToCartInstantInput.on(
                "blur",
                debounce((event) => {
                    let $input = $(event.currentTarget)
                    let id = $input.data("id")
                    let count = Math.abs($input.val()) || 1

                    handleAjaxChangeCountOnCartPage(id, count, $input)
                }, 500)
            )

            $cartDeletes.on("click", (event) => {
                event.preventDefault()

                let $target = $(event.currentTarget)
                let id = $target.data("id")

                handleAjaxSoftDelete(id, true)
            })

            $cartRestores.on("click", (event) => {
                event.preventDefault()

                let $target = $(event.currentTarget)
                let id = $target.data("id")

                handleAjaxSoftDelete(id, false)
            })

            $cartDestroys.on("click", (event) => {
                event.preventDefault()

                let $target = $(event.currentTarget)
                let id = $target.data("id")

                handleAjaxDestroy(id)
            })

            $inputHighlighted.on("input", (event) => {
                let $input = $(event.currentTarget)
                let id = $input.data("id")

                if ($input.val() > 1) {
                    handleHighlightInput($input)
                } else if (!Products.isInCart(id)) {
                    handleRemoveHighlightInput($input)
                }
            })
        }

        function handleAjaxDestroy(id) {
            ajaxDestroy(id).then((response) => {
                let { data: cartItems } = response
                Products.setCartItems(cartItems)
                handleAnimate()
                handleRenderSidebarMenuCartList()
                handleUpdateCount()

                if (!Products.isInCartWithTrashed(id)) {
                    getCartRow$(id).remove()
                }
            })
        }

        function handleAjaxSoftDelete(id, shouldDelete) {
            ajaxSoftDelete(id, shouldDelete).then((response) => {
                let { data: cartItems } = response
                Products.setCartItems(cartItems)
                handleAnimate()
                handleRenderSidebarMenuCartList()
                handleUpdateCount()

                console.log(
                    Products.isInCart(id),
                    Products.isInCartWithTrashed(id)
                )

                if (Products.isInCart(id)) {
                    let $cartRow = getCartRow$(id)
                    $cartRow.removeClass("deleted-row")
                    getCartColumnCountPartNormal$(id).show()
                    getCartColumnCountPartDeleted$(id).hide()
                    getCartDelete$(id).show()
                } else if (Products.isInCartWithTrashed(id)) {
                    let $cartRow = getCartRow$(id)
                    $cartRow.addClass("deleted-row")
                    getCartColumnCountPartNormal$(id).hide()
                    getCartColumnCountPartDeleted$(id).show()
                    getCartDelete$(id).hide()
                } else {
                    console.warn(
                        "Something wrong. This item should not be force deleted."
                    )
                }
            })
        }

        function handleAjaxChangeCountOnCartPage(id, count, $input) {
            ajaxChangeCount(id, count, "new").then((response) => {
                let { data: cartItems } = response
                Products.setCartItems(cartItems)
                handleAnimate()
                handleRenderSidebarMenuCartList()
                handleUpdateCount()

                let item = Products.find(id)
                if (item) {
                    $input.val(item.count || 1)
                    let $cartItemSumFormatted = getCartItemSumFormatted$(id)
                    $cartItemSumFormatted.text(item.price_sum_formatted)
                }
            })
        }

        function handleSidebarCartMenu() {
            $addToCartCountsTooltip.each((ind, el) => {
                $(el).tooltip({
                    trigger: "manual",
                    boundary: "window",
                    placement: "bottom",
                    title: "<b>Добавлено в корзину</b>",
                    html: true,
                })
            })

            $addToCarts.each((ind, el) => {
                let $addToCart = $(el)

                let id = $addToCart.data("id")

                $addToCart.popover({
                    template: `
                    <div class="popover popover-add-to-cart ${getAddToCartPopoverClass(
                        id
                    )}">
                        <div class="popover-header"></div>
                        <div class="line">
                            <a href="${window.cartRoute}">Перейти в корзину</a>
                            <a href="#" class="add-to-cart-hide">Остаться</a>
                        </div>
                    </div>
                `,
                    trigger: "manual",
                    placement: "bottom",
                    title: "<b>Добавлено в корзину</b>",
                    html: true,
                    delay: 0,
                })

                let popoverTimout
                $addToCart.on("shown.bs.popover", (event) => {
                    popoverTimout = setTimeout(() => {
                        $addToCart.popover("hide")
                    }, TIMEOUT_POPOVER_MS)
                    getAddToCartPopover$(id)
                        .find(".add-to-cart-hide")
                        .on("click", (e) => {
                            e.preventDefault()
                            clearTimeout(popoverTimout)
                            $addToCart.popover("hide")
                        })
                })

                $addToCart.on(
                    "click",
                    debounce((event) => {
                        event.preventDefault()
                        let id = +$addToCart.data("id")
                        let isInCart = Products.isInCart(id)
                        let $input = $(`.${getAddToCartInputCountClass(id)}`)
                        let count = Math.abs($input.val()) || 1

                        clearTimeout(popoverTimout)
                        $addToCart.popover("hide")

                        if (isInCart) {
                            ajaxChangeCount(id, count).then((response) => {
                                let { data: cartItems } = response
                                Products.setCartItems(cartItems)
                                handleAnimate()
                                handleTooltip()
                                handleRenderSidebarMenuCartList()
                                handleUpdateCount()

                                $addToCart.popover("show")

                                let $input = $(
                                    `.${getAddToCartInputCountClass(id)}`
                                )
                                if ($input.length) handleHighlightInput($input)

                                return response
                            })
                        } else {
                            ajaxAddNewItemToCart(id, count).then((response) => {
                                let { data: cartItems } = response
                                Products.setCartItems(cartItems)
                                handleAnimate()
                                handleTooltip()
                                handleRenderSidebarMenuCartList()
                                handleUpdateCount()
                                $addToCart.addClass(IS_IN_CART_CLASS)
                                $addToCart.text("Добавить")

                                $addToCart.popover("show")

                                let $input = $(
                                    `.${getAddToCartInputCountClass(id)}`
                                )
                                if ($input.length) handleHighlightInput($input)

                                return response
                            })
                        }
                    }, 500)
                )
            })
        }

        let isAnimating = false
        let isTooltip = false

        let animationTimeout
        let tooltipTimeout

        function handleAnimate() {
            if (isAnimating) {
                clearAnimation()
                animate()
            } else {
                animate()
            }
        }

        function handleTooltip() {
            if (isTooltip) {
                clearTooltip()
                tooltip()
            } else {
                tooltip()
            }
        }

        function tooltip() {
            isTooltip = true
            $addToCartCountsTooltip.each((ind, el) => {
                let $el = $(el)
                if ($el.is(":visible")) $el.tooltip("show")
            })

            tooltipTimeout = setTimeout(() => {
                $addToCartCountsTooltip.tooltip("hide")
                isTooltip = false
            }, TIMEOUT_MS)
        }

        function clearTooltip() {
            clearTimeout(tooltipTimeout)
            isTooltip = false
            $addToCartCountsTooltip.tooltip("hide")
        }

        function animate() {
            isAnimating = true
            $addToCartCountsAnimate.addClass(animationClass)

            animationTimeout = setTimeout(() => {
                $addToCartCountsAnimate.removeClass(animationClass)
                isAnimating = false
            }, TIMEOUT_MS)
        }

        function clearAnimation() {
            clearTimeout(animationTimeout)
            isAnimating = false
            $addToCartCountsAnimate.removeClass(animationClass)
        }

        function handleRenderSidebarMenuCartList() {
            if (Products.getCartItems().length) {
                $sidebarMenuCart.show()
            } else {
                $sidebarMenuCart.hide()
            }

            let newHtml = ""

            Products.getCartItems()
                .slice(0, 10)
                .forEach(
                    ({
                        name,
                        price_formatted,
                        unit,
                        count,
                        route,
                        price_name,
                    }) => {
                        newHtml += Mustache.render(sidebarMenuTemplate, {
                            url: route,
                            name,
                            count,
                            priceName: price_name,
                            priceFormatted: price_formatted,
                            unit,
                        })
                    }
                )

            $sidebarMenuCartList.html(newHtml)

            let totalSum = Products.getCartItemsTotalPrice()

            $totalSumFormatted.html(`${numberWithSpaces(totalSum)} р`)
        }

        function handleUpdateCount() {
            $addToCartCounts.text(Products.getCartItemsCount())
        }

        function ajaxAddNewItemToCart(id, count) {
            return Rest.POST(ajaxUrls.productInCart, { id, count })
                .then(Rest.middleThen)
                .catch(Rest.simpleCatch)
        }

        function ajaxChangeCount(id, count, updateCountMode = "add") {
            return Rest.PUT(ajaxUrls.productInCart, {
                id,
                count,
                updateCountMode,
            })
                .then(Rest.middleThen)
                .catch(Rest.simpleCatch)
        }

        function ajaxSoftDelete(id, shouldDelete) {
            return Rest.PUT(ajaxUrls.productInCart, {
                id,
                delete: shouldDelete,
            })
                .then(Rest.middleThen)
                .catch(Rest.simpleCatch)
        }

        function ajaxDestroy(id) {
            return Rest.DELETE(ajaxUrls.productInCart, { id })
                .then(Rest.middleThen)
                .catch(Rest.simpleCatch)
        }

        function handleHighlightInput($input) {
            $input.addClass(inputHighlightedClass)
        }

        function handleRemoveHighlightInput($input) {
            $input.removeClass(inputHighlightedClass)
        }

        // todo ajax request
    })
})(jQuery)
