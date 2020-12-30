import ajaxUrls from "../settings/ajaxUrls"
import Rest from "../../helpers/Rest"
import {getProductItemComponentClass, isProductsAsidePage, getProductsAsidePageContentWrapper, PRODUCT_HOVER_ON_POPOVER_CLASS} from "../helpers/products"

(function($){
    $().ready(() => {
        let activeClass = "put-off-block__link--active"
        let pendingClass = "js-put-aside-pending"

        let $asideItemsCount = $(".js-aside-items-count")

        let $putAsides = $(".js-put-aside")
        $putAsides.each((ind, el) => {
            let $putAside = $(el)
            $putAside.on("click", event => {
                event.preventDefault()

                let $target = $(event.target)
                let isPending = $target.hasClass(pendingClass)
                if (isPending) return true

                let isActive = $target.hasClass(activeClass)

                $target.addClass(pendingClass)

                if (isActive) {
                    handleRemoveFromAside($target)
                } else {
                    handleAddToAside($target)
                }
            })
        })

        function handleRemoveFromAside($toggler) {
            let productId = $toggler.data("id")

            Rest.DELETE(ajaxUrls.putProductAside, {id : productId})
                .then(Rest.middleThen)
                .then(({data : {count}}) => {
                    $asideItemsCount.text(count)
                    $toggler.removeClass(activeClass)

                    handleRemoveAsideProductNode(productId)
                })
                .catch(Rest.simpleCatch)
                .finally(() => $toggler.removeClass(pendingClass))
        }

        function handleAddToAside($toggler) {
            let productId = $toggler.data("id")

            Rest.POST(ajaxUrls.putProductAside, {id: productId})
                .then(Rest.middleThen)
                .then(({data : {count}}) => {
                    $asideItemsCount.text(count)
                    $toggler.addClass(activeClass)
                })
                .catch(Rest.simpleCatch)
                .finally(() => $toggler.removeClass(pendingClass))
        }

        function handleRemoveAsideProductNode(productId) {
            if (isProductsAsidePage()) {
                let $pageContentWrapper = getProductsAsidePageContentWrapper()
                let $node = $pageContentWrapper.find(`.${getProductItemComponentClass(productId)}`)
                if ($node.length) {
                    let $popover = $node.find(`.${PRODUCT_HOVER_ON_POPOVER_CLASS}`)
                    $popover.popover("hide")
                    $node.remove()
                } else {
                    console.warn("Something wrong, can't find product dom node on aside products page.")
                }
            }
        }
    })
})(jQuery)
