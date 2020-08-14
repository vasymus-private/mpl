import {getAddToCartInputCountClass} from "../helpers/products"
import Rest from "../helpers/Rest"
import ajaxUrls from "../settings/ajaxUrls"
import Mustache from "mustache"
import {numberWithSpaces} from "../helpers/common"
import {debounce} from 'lodash'
import Products from '../Products'


(function($) {
    $().ready(() => {
        let animationClass = "pulsing"


        let $addToCarts = $(".js-add-to-cart")
        let $addToCartCounts = $(".js-add-to-cart-count")
        let $addToCartCountsAnimate = $addToCartCounts.filter("[data-should-animate]")
        let $addToCartCountsTooltip = $addToCartCounts.filter("[data-should-tooltip]")

        let $sidebarMenuCart = $(".js-sidebar-menu-cart")
        let $sidebarMenuCartList = $(".js-sidebar-menu-cart-list")
        let $_sidebarMenuTemplate = $("#sidebar-menu-cart-item")
        let sidebarMenuTemplate = $_sidebarMenuTemplate.html()

        let $totalSumFormatted = $(".js-cart-total-sum-formatted")

        $addToCartCountsTooltip.tooltip({
            trigger : "manual"
        })

        $addToCarts.each((ind, el) => {
            let $addToCart = $(el)
            $addToCart.on("click", debounce(event => {
                event.preventDefault()
                let id = +$addToCart.data("id")
                let isInCart = Products.isInCart(id)
                let $input = $(`.${getAddToCartInputCountClass(id)}`)
                let count = Math.abs($input.val()) || 1

                if (isInCart) {
                    handleAddCount(id, count)
                } else {
                    handleAddNewItemToCart(id, count, $addToCart)
                }
            }, 500))
        })

        let isAnimating = false
        let timeout

        function handleAnimate() {
            if (isAnimating) {
                clearAnimation()
                animate()
            } else {
                animate()
            }
        }

        function animate() {
            isAnimating = true
            $addToCartCountsAnimate.addClass(animationClass)
            $addToCartCountsTooltip.tooltip("show")

            timeout = setTimeout(() => {
                $addToCartCountsAnimate.removeClass(animationClass)
                $addToCartCountsTooltip.tooltip("hide")
                isAnimating = false
            }, 3000)
        }

        function clearAnimation() {
            clearTimeout(timeout)
            isAnimating = false
            $addToCartCountsAnimate.removeClass(animationClass)
        }

        function handleRenderSidebarMenuCartList(cartItems = []) {
            let newHtml = ""

            cartItems.slice(0, 10).forEach(({name, price_formatted, unit, count, route, price_name}) => {
                newHtml += Mustache.render(sidebarMenuTemplate, {
                    url : route,
                    name,
                    count,
                    priceName : price_name,
                    priceFormatted : price_formatted,
                    unit,
                })
            })

            $sidebarMenuCartList.html(newHtml)

            let totalSum = cartItems.reduce((acc, {price_rub, count}) => {
                return acc += (price_rub * count)
            }, 0)

            $totalSumFormatted.html(`${numberWithSpaces(totalSum)} р`)
        }

        function handleUpadeCount(cartItems = []) {
            let count = cartItems.reduce((acc, item) => {
                return acc += (item.count || 1)
            }, 0)
            $addToCartCounts.text(count)
        }

        function handleAddNewItemToCart(id, count, $btn) {
            Rest.POST(ajaxUrls.putProductToCart, { id, count })
                .then(Rest.middleThen)
                .then(({data : cartItems}) => {
                    Products.setCartIds(cartItems.map(item => item.id))
                    handleAnimate()
                    $sidebarMenuCart.show()
                    handleRenderSidebarMenuCartList(cartItems)
                    handleUpadeCount(cartItems)
                    $btn.text("Добавить")
                })
                .catch(Rest.simpleCatch)
        }

        function handleAddCount(id, count) {
            Rest.PUT(ajaxUrls.putProductToCart, { id, count })
                .then(Rest.middleThen)
                .then(({data : cartItems}) => {
                    Products.setCartIds(cartItems.map(item => item.id))
                    handleAnimate()
                    handleRenderSidebarMenuCartList(cartItems)
                    handleUpadeCount(cartItems)
                })
                .catch(Rest.simpleCatch)
        }

        // todo ajax request
    })
})(jQuery)
