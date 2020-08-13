import {getAddToCartInputCountClass} from "../helpers/products"
import Rest from "../helpers/Rest"
import ajaxUrls from "../settings/ajaxUrls"
import Mustache from "mustache"


(function($) {
    $().ready(() => {
        let animationClass = "pulsing"

        let $cart = $(".js-cart")
        let $cartCount = $(".js-cart-count")

        let $addToCarts = $(".js-add-to-cart")
        let $addToCartCount = $(".js-add-to-cart-count")

        let $sidebarMenuCartList = $(".js-sidebar-menu-cart-list")
        let $_sidebarMenuTemplate = $("#sidebar-menu-cart-item")
        let sidebarMenuTemplate = $_sidebarMenuTemplate.html()

        let isPending = false

        $addToCarts.each((ind, el) => {
            let $addToCart = $(el)
            let id = $addToCart.data("id")
            let isInCart = !!$addToCart.data("isInCart")
            let $input = $(getAddToCartInputCountClass(id))
            let count = Math.abs($input.val()) || 1

            if (isInCart) {
                handleAddCount(id, count)
            } else {
                handleAddNewItemToCart(id, count)
            }
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
            $addToCartCount.addClass(animationClass)
            timeout = setTimeout(() => {
                $addToCartCount.removeClass(animationClass)
                isAnimating = false
            }, 3000)
        }

        function clearAnimation() {
            clearTimeout(timeout)
            isAnimating = false
            $addToCartCount.removeClass(animationClass)
        }

        function handleRenderSidebarMenuCartList(cartItems = []) {
            let newHtml = ""

            cartItems.forEach(({name, price_formatted, unit, count, route, price_name}) => {
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
        }

        function handleAddNewItemToCart(id, count) {
            Rest.PUT(ajaxUrls.putProductToCart(), { id, count })
                .then(Rest.middleThen)
                .then(({data : cartItems}) => {
                    handleAnimate()
                    handleRenderSidebarMenuCartList(cartItems)
                })
                .catch(Rest.simpleCatch)
        }

        function handleAddCount(id, count) {
            Rest.POST(ajaxUrls.putProductToCart(), { id, count })
                .then(Rest.middleThen)
                .then(({data : cartItems}) => {
                    handleAnimate()
                    handleRenderSidebarMenuCartList(cartItems)
                })
                .catch(Rest.simpleCatch)
        }

        // todo ajax request
    })
})(jQuery)
